import ViewComponent from "./ViewComponent";
import ViewHtmlHelper from "./ViewHtmlHelper";

export default class ViewComponentInitializer {
    public static attachComponent(selectors: string, componentClass: typeof ViewComponent) {
        document.addEventListener('init', this.initComponent.bind(this, selectors, componentClass));
        this.initComponent(selectors, componentClass);
    }

    public static dispatchInit(element: HTMLElement, url: URL = null) {
        document.dispatchEvent(new CustomEvent('destroy'));
        const event = this.createInitEvent(url);
        element.dispatchEvent(event);
    }

    protected static createInitEvent(url: URL = null) {
        return new CustomEvent('init', {
            bubbles: true,
            detail: {
                url: url ?? new URL(document.location.href, document.baseURI)
            }
        });
    }

    protected static initComponent(selectors: string, componentClass: typeof ViewComponent, event: CustomEvent = null) {
        if (event === null) {
            event = this.createInitEvent();
        }
        const url = event.detail.url ?? new URL(document.location.href, document.baseURI);
        const target = document.documentElement;

        const html = new ViewHtmlHelper(target as HTMLElement);
        html.find(selectors).forEach(this.initComponentElement.bind(this, selectors, componentClass, url));
    }

    protected static initComponentElement(selectors: string, componentClass: typeof ViewComponent, url: URL, element: HTMLElement) {
        const component = new componentClass(element, selectors, url);
        if (element.previousElementSibling) {
            const hasHandler = element.previousElementSibling.matches('[data-handler]');
            if (hasHandler) {
                component.requestHandler = (element.previousElementSibling as HTMLElement).dataset.handler;
            }
        }
        component.init();
    }
}