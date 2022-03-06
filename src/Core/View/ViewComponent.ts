import ViewEventHandler from "./ViewEventHandler";
import ViewWindow from "./ViewWindow";
import ViewEvent from "./ViewEvent";
import ViewComponentInitializer from "./ViewComponentInitializer";
import ViewHtmlHelper from "./ViewHtmlHelper";

export default class ViewComponent {
    public url: URL;
    public element: HTMLElement;
    public selectors: string;
    public eventHandler: ViewEventHandler;
    public requestHandler: string;

    constructor(element: HTMLElement, selectors: string, url: URL) {
        this.url = url;
        this.element = element;
        this.selectors = selectors;
        this.eventHandler = new ViewEventHandler(this);
    }

    public init() {
        this.eventHandler.init();
    }

    public static attach(selectors: string) {
        ViewComponentInitializer.attachComponent(selectors, this);
    }

    public handleViewEvent(viewEvent: ViewEvent, responseHtml: string) {
        if (this === viewEvent.component
            || viewEvent.handler && viewEvent.handler === this.requestHandler) {
            this.handleResponse(viewEvent, responseHtml);
        }
    }

    protected handleResponse(viewEvent: ViewEvent, html: string) {
        switch (viewEvent.target) {
            case ViewEvent.TARGET_BLANK:
                return this.handleTargetBlank(viewEvent);
            case ViewEvent.TARGET_SELF:
                return this.handleTargetSelf(viewEvent, html)
            case ViewEvent.TARGET_ACTION:
                return this.handleTargetAction(viewEvent, html);
            case ViewEvent.TARGET_WINDOW:
                return this.handleTargetWindow(viewEvent, html);
        }
    }

    protected handleTargetBlank(viewEvent: ViewEvent) {
        window.open(viewEvent.url, '_blank').focus();
    }

    protected handleTargetAction(viewEvent: ViewEvent, html: string) {
        html = html.trim();
        if (html) {
            const newElement = ViewHtmlHelper.fromString(html).first();
            if (newElement) {
                this.eventHandler.destroyViewEvent();
                const target = this.element;
                this.element = newElement;
                target.replaceWith(this.element);
                ViewComponentInitializer.dispatchInit(this.element, new URL(viewEvent.url, document.baseURI));
            }
        }
    }

    protected handleTargetWindow(viewEvent: ViewEvent, html: string) {
        const window = new ViewWindow(viewEvent, html);
        ViewComponentInitializer.dispatchInit(window.body, new URL(viewEvent.url, document.baseURI));
    }

    protected handleTargetSelf(viewEvent: ViewEvent, html: string) {
        history.replaceState({}, '', viewEvent.url);
        this.handleTargetAction(viewEvent, html);
    }

}