import './OverviewComponent.scss';
import ViewComponent from "../ViewComponent";

export default class OverviewComponent extends ViewComponent {

}

document.querySelectorAll('.overview').forEach(element => {
   const component = new OverviewComponent(new URL(window.location.href, document.baseURI), element as HTMLElement);
   component.init();
});