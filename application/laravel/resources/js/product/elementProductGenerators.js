import {Requests} from './../requests.js';

/**
 * Набор функций генерации объектов на странице
 */
export class ElementProductGenerators {
    /**
     * Собирает и наполняет информацией карточку продукта
     */
    static genProductCard() {
        let id = document.querySelector('main').dataset.productId;
        Requests.getProductInfo(Number(id)).then(data => {
            let product = data['data'];

            document.querySelector('h1.text-body-emphasis').append(product['name']);
            document.querySelector('p.price').append(
                `Цена: ${product['price']['price']} ₽`
            );
            //Асинхронно заполняет "Хлебные крошки" продукта
            Requests.getOmniGroupList(product['id_group']).then(data_1 => {
                let groupsArray = data_1['data'].reverse();

                document.querySelector('ol.breadcrumb').append(
                    this.#genFragments.breadCrumb(groupsArray)
                );
            });
        });
    }

    /**
     * Набор функций, отвечающих за генерацию таблицы контактов
     */
    static #genFragments = {
        /**
         * Из полученной информации в массиве групп собирает "хлебные крошки"
         * @param groupsArray
         * @return {DocumentFragment}
         */
        breadCrumb: groupsArray => {
            let $fragment = new DocumentFragment();
            groupsArray.forEach(group => {
                let add = this.#shortCreate(
                    'li',
                    {
                        class: 'breadcrumb-item'
                    },
                    this.#shortCreate(
                        'a',
                        null,
                        group['name']
                    )
                );
                $fragment.append(add);
            })
            return $fragment;
        }
    }

    /**
     * Вспомогательный метод для упрощения сборки DOM-элементов
     * @param tag {String}
     * @param attributes {*}
     * @param append
     * @return {*}
     */
    static #shortCreate = (tag, attributes = null, append = null) => {
        let $element = document.createElement(tag);
        if(attributes!== null) {
            for (let attrName in attributes) {
                $element.setAttribute(attrName, attributes[attrName]);
            }
        }
        if(append!== null) {
            $element.append(append);
        }
        return $element;
    }
}
