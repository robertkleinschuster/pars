import "./Tree.scss";
import ViewComponent from "../ViewComponent";

class TreeComponent extends ViewComponent {
    init() {
        super.init();
        this.element.querySelectorAll('.tree__item').forEach(item => {
            item.addEventListener('click', event => {
                const state = (event.currentTarget as HTMLElement).classList.toggle('open');
                if (!state) {
                    (event.currentTarget as HTMLElement).querySelectorAll('.tree__item').forEach(element => {
                        element.classList.remove('open');
                    });
                }
                event.stopImmediatePropagation();
            });
        });
    }
}


class TreeElement extends HTMLUListElement {
    protected component: ViewComponent;
    constructor() {
        super();
        this.component = new TreeComponent(this);
    }
}

customElements.define('core-tree', TreeElement, {extends: 'ul'});



