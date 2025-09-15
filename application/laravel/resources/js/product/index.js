import {ElementProductGenerators} from "./elementProductGenerators.js";

//При загрузке страницы запускает скрипт генерации карточки продукта
window.onload = () => {
    ElementProductGenerators.genProductCard();
};
