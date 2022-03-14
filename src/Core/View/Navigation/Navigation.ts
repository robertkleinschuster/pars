import "./NavigationComponent.scss";
import ViewComponent from "../ViewComponent";

class NavigationElement extends HTMLUListElement
{
    protected component: ViewComponent;
    constructor() {
        super();
        this.component = new ViewComponent(this);
    }
}

customElements.define('core-navigation', NavigationElement, {extends: 'ul'});
