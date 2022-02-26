import "./Tree.scss";
import ViewComponent from "../ViewComponent";

export default class Tree extends ViewComponent {

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

document.querySelectorAll('.tree').forEach(element => {
    const component = new Tree(new URL(window.location.href, document.baseURI), element as HTMLElement);
    component.init();
});