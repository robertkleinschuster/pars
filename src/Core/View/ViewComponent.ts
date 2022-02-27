import ViewEventHandler from "./ViewEventHandler";
import ViewWindow from "./ViewWindow";
import ViewEvent from "./ViewEvent";

export default class ViewComponent {
    public url: URL;
    public element: HTMLElement;
    public window: ViewWindow;
    public eventHandler: ViewEventHandler;
    public requestHandler: string;

    constructor(url: URL, element: HTMLElement, window: ViewWindow = null) {
        this.url = url;
        this.element = element;
        this.window = window;
        this.eventHandler = new ViewEventHandler(this);
    }

    public init()
    {
        if (this.element.previousElementSibling) {
            const hasHandler = this.element.previousElementSibling.matches('[data-handler]');
            if (hasHandler) {
                this.requestHandler = (this.element.previousElementSibling as HTMLElement).dataset.handler;
            }
        }
        this.eventHandler.init();
    }

    public static attach(selectors: string) {
        document.addEventListener("init", (event: CustomEvent) => {
            const element = event.target as HTMLElement;
            if (element.matches && element.matches(selectors)) {
                const component = new this(event.detail.url, element as HTMLElement);
                component.init();
            } else {
                element.querySelectorAll(selectors).forEach(element => {
                    const component = new this(event.detail.url, element as HTMLElement);
                    component.init();
                });
            }
        });
    }

    public handleViewEvent(viewEvent: ViewEvent, source: ViewComponent, responseHtml: string) {
        if (viewEvent.handler) {
            if (viewEvent.handler == this.requestHandler) {
                this.handleResponse(viewEvent, responseHtml);
            }
        } else if (this == source) {
             this.handleResponse(viewEvent, responseHtml);
        }
    }

    protected handleResponse(viewEvent: ViewEvent, html: string) {
        switch (viewEvent.target) {
            case 'blank':
                return this.handleTargetBlank(viewEvent);
            case 'self':
                return this.handleTargetSelf(viewEvent, html)
            case 'action':
                return this.handleTargetAction(viewEvent, html);
            case 'window':
                return this.handleTargetWindow(viewEvent, html);
        }
    }

    protected handleTargetBlank(viewEvent: ViewEvent) {
        window.open(viewEvent.url, '_blank').focus();
    }

    protected handleTargetAction(viewEvent: ViewEvent, html: string) {
        html = html.trim();
        if (html) {
            const target = this.element;
            const tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = html;
            this.element = tmpDiv.firstElementChild as HTMLElement;
            target.replaceWith(this.element);
            this.element.dispatchEvent(new CustomEvent('init', {
                bubbles: true,
                detail: {
                    url: new URL(viewEvent.url, document.baseURI)
                }
            }));
        }
    }

    protected handleTargetWindow(viewEvent: ViewEvent, html: string) {
        return new ViewWindow(viewEvent, html, this.window);
    }


    protected handleTargetSelf(viewEvent: ViewEvent, html: string) {
        history.replaceState({}, '', viewEvent.url);
        this.handleTargetAction(viewEvent, html);
    }

}