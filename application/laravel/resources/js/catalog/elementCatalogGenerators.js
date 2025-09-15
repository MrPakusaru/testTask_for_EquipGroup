import {Requests} from './../requests.js';
import {ObjectListeners} from './../objectListeners.js';

/**
 * Набор функций генерации объектов на странице
 */
export class ElementCatalogGenerators {
    /**
     * Общий генератор иерархического списка групп
     */
    static genGroupCatalog() {
        Requests.getGroups().then(data => {
            self.GROUPS = data['data'];
            document.querySelector('.categories').append(
                this.#genFragments.groupsTree(self.GROUPS)
            );
            //Обработчики событий:
            ObjectListeners.getProductsByGroupId();
        });
    }

    /**
     * Общий генератор списка продуктов
     */
    static genProductList(ifRegen = false) {
        Requests.getProductsByGroupId().then(data => {
            let productArray = data['data'];
            let $product_list = document.querySelector('.product_list');
            if(ifRegen) $product_list.textContent = '';
            $product_list.append(this.#genFragments.productsList(productArray));

            ElementCatalogGenerators.genPaginationNums(data['additional']['max_pages']);
        });
    }

    /**
     *  Общий генератор кнопог пагинации
     * @param maxPages
     */
    static genPaginationNums(maxPages) {
        let $pagination = document.querySelector('ul.pagination');
        $pagination.textContent = '';
        $pagination.append(this.#genFragments.pagesPagination(
            maxPages,
            Number(Requests.query_params.page_num)
        ));
        //Обработчики событий:
        ObjectListeners.changeProductsPage();
    }


    /**
     * Набор функций, отвечающих за генерацию DOM объектов
     */
    static #genFragments = {
        /**
         * Собирает и наполняет полученными данными иерархический список групп
         * @param groupArray
         * @return {DocumentFragment}
         */
        groupsTree: groupArray => {
            let $fragment = new DocumentFragment();
            groupArray.forEach(group => {
                let ifHaveSubGroup = group.hasOwnProperty('subGroup');
                let $group_li = this.#shortCreate(
                    'li',
                    null,
                    this.#shortCreate(
                        'a',
                        {
                            id: group['id'],
                            class: 'group_product link-primary rounded'
                        },
                        group['name']+' ('+group['productsQuantity']+')'
                    )
                );
                if(ifHaveSubGroup) {
                    let $group_sub_ul = this.#shortCreate(
                        'ul',
                        {
                            class: 'btn-toggle-nav list-unstyled fw-normal pb-1 small'
                        },
                        this.#genFragments.groupsTree(group['subGroup'])
                    )
                    $group_li.setAttribute('class', 'mb-1');
                    $group_li.append($group_sub_ul);
                }

                $fragment.append($group_li);
            });
            return $fragment;
        },
        /**
         * Собирает список продуктов
         * @return {DocumentFragment}
         * @param productArray
         */
        productsList: productArray => {
            let $fragment = new DocumentFragment();
            let temp = Array.from(productArray);
            temp.forEach(product => {
                let $product_li = this.#shortCreate(
                    'li',
                    null,
                    this.#shortCreate(
                        'a',
                        {
                            id: product['id'],
                            'class': 'link-primary rounded',
                            href: new URL(window.location.href).origin + '/products/' + product['id']
                        },
                        `${product['name']} - ${product['price']['price']} ₽`
                    )
                );
                $fragment.append($product_li);

            });
            return $fragment;
        },
        /**
         * Собирает бар для пагинации страниц
         * @param maxPages
         * @param currentPage
         * @return {DocumentFragment}
         */
        pagesPagination: (maxPages, currentPage) => {
            let $fragment = new DocumentFragment();

            for (let pageNum = 0; pageNum < maxPages + 2; pageNum++) {
                //Создаём объект кнопки и наполняем её свойствами в зваисимости от её положения в ряде
                let b = {};
                switch (pageNum) {
                    //'Предыдущая'
                    case 0:
                        b.id = currentPage > 1 ? currentPage - 1 : null;
                        b.ifDisabled = currentPage === 1 ? 'disabled' : '';
                        b.name = 'Предыдущая';
                        b.ifActive = '';
                        break;
                    //'Следующая'
                    case maxPages + 1:
                        b.id = currentPage < maxPages ? currentPage + 1 : null;
                        b.ifDisabled = currentPage === maxPages ? 'disabled' : '';
                        b.name ='Следующая';
                        b.ifActive = '';
                        break;
                    //'1 2 3 ...'
                    default:
                        b.id = b.name = pageNum;
                        b.ifDisabled = '';
                        b.ifActive = pageNum === currentPage ? 'active' : '';
                        break;
                }
                //Создаём DOM кнопок, помещаем в них свойства
                let $product_li = this.#shortCreate(
                    'li',
                    {
                        'class': `page-item ${b.ifActive} ${b.ifDisabled}`
                    },
                    this.#shortCreate(
                        'a',
                        {
                            id: b.id,
                            'class': 'page-link'
                        },
                        b.name
                    )
                );
                //Добавляем собранные кнопки в набор фрагмента
                $fragment.append($product_li);
            }
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
