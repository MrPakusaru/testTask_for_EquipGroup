/**
 * Набор функций с запросами к серверу
 */
export class Requests {
    /**
     * Общий запрос для списка продуктов. Изменяется по частям.
     * @type {{page_num: number, chunk_by: number, sort_by: string, id_group: number}}
     */
    static query_params = {
        id_group: 0,
        sort_by: 'name',
        chunk_by: 6,
        page_num: 1
    }
    /**
     * URL сервера
     * @type {string}
     */
    static #server_addr = new URL(window.location.href).origin;
    /**
     * Возвращает полную ссылку из адреса сервера и остатка ссылки
     * @param pathName {string} Часть ссылки (всё, что между 'port/' и '/?=')
     * @param searchParams {*}
     * @returns {string}
     */
    static toAPI = (pathName = '', searchParams = null) => this.#server_addr.concat('/api/', pathName, '/',
        searchParams === null ? '' : `?${new URLSearchParams(searchParams).toString()}`
    );
    /**
     * Способы обработать ответ от сервера
     * @type {{JSON: string, TEXT: string}}
     */
    static #contentType = {
        JSON: 'application/json',
        TEXT: 'text/html; charset=UTF-8'
    };
    /**
     * Функция-обёртка для fetch.
     *
     * Проверяет получаемый тип данных с ожидаемым.
     * Возвращает обработанный ответ внутри Promise.
     * В случае ошибки возвращает null.
     * @param fetchFunc Функция fetch со вложенными в неё параметрами
     * @param responseTypeContent Тип контента из ожидаемого ответа (брать из `this.#contentType`)
     * @returns {Promise<any> | null}
     */
    static #throwResponse = (fetchFunc, responseTypeContent) => fetchFunc.then(response => {
        if (response.ok) return response;
        throw response;
    }).then(response => {
        if(response.headers.get('content-type')===responseTypeContent) return response;
        throw new Error(`Response is not '${responseTypeContent}'`);
    }).then(
        promise => {
            switch (responseTypeContent) {
                case this.#contentType.JSON: return promise.json();
                case this.#contentType.TEXT: return promise.text();
                default: throw new Error('Type response is not set or received otherwise');
            }
        }
    ).catch((error) => {
        console.error(`${error.status !== undefined ? error.status + ': ' + error.statusText : ''}${error.message ?? ''}`);
        return null;
    });
    /**
     * Обращается к серверу за получением иерархического списка групп
     * @returns {Promise<*>|null}
     */
    static getGroups = () => this.#throwResponse(fetch(
        this.toAPI('groups'),
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
        }
    ),this.#contentType.JSON);

    /**
     * Обращается к серверу за получением списка продуктов с параметрами и условиями
     * @return {Promise<*>|null}
     */
    static getProductsByGroupId = () => this.#throwResponse(fetch(
        this.toAPI('products', Requests.query_params),
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
        }
    ), this.#contentType.JSON);

    /**
     * Обращается к серверу за получением информации о продукте
     * @return {Promise<*>|null}
     */
    static getProductInfo = id => this.#throwResponse(fetch(
        this.toAPI('products')+id,
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
        }
    ), this.#contentType.JSON);

    /**
     * Обращается к серверу за получением списка родительских групп
     * @return {Promise<*>|null}
     */
    static getOmniGroupList = id => this.#throwResponse(fetch(
        this.toAPI('groups/omnigroups')+id,
        {
            method: 'GET',
            headers: {'Content-Type': 'application/json'}
        }
    ), this.#contentType.JSON);
}
