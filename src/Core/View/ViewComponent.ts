import ViewEventHandler from "./ViewEventHandler";
import ViewWindow from "./ViewWindow";
import ViewEvent from "./ViewEvent";

export default class ViewComponent {
    public element: HTMLElement;
    public selectors: string;
    public eventHandler: ViewEventHandler;

    constructor(element: HTMLElement) {
        this.element = element;
        this.eventHandler = new ViewEventHandler(this);
        this.init();
    }

    protected init() {
        this.eventHandler.init();
    }

    public handleViewEvent(viewEvent: ViewEvent, responseHtml: string) {
        this.handleResponse(viewEvent, responseHtml);
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
        const parser = new DOMParser();
        const dom = parser.parseFromString(html, 'text/html');
        this.element.closest('main')
            .replaceWith(dom.body.querySelector('main'));

    }

    protected handleTargetWindow(viewEvent: ViewEvent, html: string) {
        const parser = new DOMParser();
        const dom = parser.parseFromString(html, 'text/html');
        const main = dom.querySelector('main');
        const window = new ViewWindow(viewEvent, main);
    }

    protected handleTargetSelf(viewEvent: ViewEvent, html: string) {
        if (!this.element.closest('.winbox')) {
            history.replaceState({}, '', viewEvent.url);
        }
        this.handleTargetAction(viewEvent, html);
    }

}