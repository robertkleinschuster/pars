import './ViewEvent.scss';
import ViewEvent from "./ViewEvent";
import ViewWindow from "./ViewWindow";


export default class ViewEventHandler {
    protected url: URL;
    protected element: HTMLElement;
    protected window: ViewWindow;

    constructor(url: URL, element: HTMLElement, window: ViewWindow = null) {
        this.url = url;
        this.element = element;
        this.window = window;
    }

    public init() {
        this.element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this));
    }

    protected initEvent(element: HTMLElement) {
        const viewEvent = new ViewEvent(element.dataset);
        element.addEventListener(viewEvent.event, event => {
            event.preventDefault();
            this.trigger(viewEvent, element);
        });
    }

    public trigger(viewEvent: ViewEvent, eventTarget: HTMLElement = null) {
        const url = new URL(viewEvent.url, document.baseURI);

        if (viewEvent.handler) {
            url.searchParams.append('handler', viewEvent.handler);
        }

        if (viewEvent.target) {
            url.searchParams.append('target', viewEvent.target);
        }

        const options: RequestInit = {};
        if (viewEvent.target == 'action') {
            options.method = 'post';
        }

        if (eventTarget) {
            const form = eventTarget.closest('form') as HTMLFormElement;

            if (form) {
                options.method = form.method ?? 'post';
                options.body = new FormData(form);
                if (eventTarget instanceof HTMLInputElement || eventTarget instanceof HTMLSelectElement || eventTarget instanceof HTMLTextAreaElement || eventTarget instanceof HTMLButtonElement) {
                    options.body.append(eventTarget.name, eventTarget.value);
                }
            }
        }

        document.body.classList.add('overlay');
        fetch(url.toString(), options).then(r => r.text()).then(html => {
            if (html) {
                this.handleResponse(viewEvent, html);
            }
            document.body.classList.remove('overlay');
        }).catch((e) => {
            console.error(e);
            window.location.href = url.toString();
        });
    }

    protected handleResponse(viewEvent: ViewEvent, html: string) {
        switch (viewEvent.target) {
            case 'action':
            case 'self':
                return this.handleTargetSelf(viewEvent, html);
            case 'window':
                return this.handleTargetWindow(viewEvent, html);
        }
    }

    protected handleTargetWindow(viewEvent: ViewEvent, html: string) {
        return new ViewWindow(viewEvent, html, this.window);
    }


    protected handleTargetSelf(viewEvent: ViewEvent, html: string) {
        const target = this.element;
        const tmpDiv = document.createElement('div');
        tmpDiv.innerHTML = html.trim();
        this.element = tmpDiv.firstElementChild as HTMLElement;
        this.init();
        target.replaceWith(this.element);
        history.replaceState({}, '', viewEvent.url);
    }
}
