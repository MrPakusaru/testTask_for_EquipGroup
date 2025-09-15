import {ElementCatalogGenerators} from "./elementCatalogGenerators.js";
import {ObjectListeners} from "./../objectListeners.js";

//При загрузке страницы запускает скрипты генерации списка групп, продуктов и кнопок сортировки
window.onload = () => {
    ElementCatalogGenerators.genGroupCatalog();
    ElementCatalogGenerators.genProductList();
    ObjectListeners.sortProductsButton();
};
