import {Requests} from "./requests.js";
import {ElementCatalogGenerators} from "./catalog/elementCatalogGenerators.js";

/**
 * Класс, содержащий функции, устанавливающие прослушиватели событий
 */
export class ObjectListeners {
    /**
     * В случае нажатия на кнопку 'a.group_product' запускает ре-генерацию списка продуктов выбранной группы
     */
    static getProductsByGroupId() {
        let $group_buttons = document.querySelectorAll('a.group_product');
        $group_buttons.forEach($g_button => {
            $g_button.addEventListener('click', e => {
                Requests.query_params.id_group = $g_button.id;
                ElementCatalogGenerators.genProductList(true);
            })
        });
    }

    /**
     * В случае нажатия на кнопку 'a.sort_by' запускает ре-генерацию списка продуктов с необходимой сортировкой
     */
    static sortProductsButton() {
        let $group_buttons = document.querySelectorAll('a.sort_by');
        $group_buttons.forEach($sort_button => {
            $sort_button.addEventListener('click', e => {
                Requests.query_params.sort_by = $sort_button.dataset.sort;
                ElementCatalogGenerators.genProductList(true);
            })
        });
    }

    /**
     * В случае нажатия на кнопку 'a.sort_by' запускает ре-генерацию списка продуктов с необходимой сортировкой
     */
    static changeProductsPage() {
        let $group_buttons = document.querySelectorAll('a.page-link');
        $group_buttons.forEach($page_button => {
            $page_button.addEventListener('click', e => {
                Requests.query_params.page_num = $page_button.id;
                ElementCatalogGenerators.genProductList(true);
            })
        });
    }
}
