import './ViewEvent.scss';
import ViewEvent from "./ViewEvent";
import ViewWindow from "./ViewWindow";
import ViewComponent from "./ViewComponent";

export default class ViewEventHandler {
    protected component: ViewComponent;

    constructor(component: ViewComponent) {
        this.component = component;
    }

    public init() {
        this.component.element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this));
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
        const options: RequestInit = {};

        options.headers = new Headers()

        if (viewEvent.handler) {
            options.headers.set('handler', viewEvent.handler);
        }

        if (viewEvent.target) {
            options.headers.set('target', viewEvent.target);
        }

        if (viewEvent.title) {
            options.headers.set('title', encodeURIComponent(viewEvent.title));
        }

        if (viewEvent.url) {
            options.headers.set('url', viewEvent.url);
        }

        if (viewEvent.id) {
            options.headers.set('id', viewEvent.id);
        }

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

        this.fetch(viewEvent, url, options);
    }

    protected fetch(viewEvent: ViewEvent, url: URL, options: RequestInit) {
        document.body.classList.add('overlay');
        options.redirect = 'manual';

        fetch(url.toString(), options)
            .then(response => {
                if (response.type == 'opaqueredirect' && viewEvent.target != 'blank') {
                    window.location.href = viewEvent.url;
                }
                if (response.status == 500) {
                    window.location.href = url.toString();
                } else {
                    this.injectJs(response);
                    this.injectCss(response);
                }
                return response;
            })
            .then(r => r.text())
            .then(html => {
                document.body.classList.remove('overlay');
                this.handleResponse(viewEvent, html);
            }).catch((e) => {
            console.error(e);
            window.location.href = url.toString();
        });
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
            const target = this.component.element;
            const tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = html;
            this.component.element = tmpDiv.firstElementChild as HTMLElement;
            target.replaceWith(this.component.element);
            this.component.init();
        }
    }

    protected handleTargetWindow(viewEvent: ViewEvent, html: string) {
        return new ViewWindow(viewEvent, html, this.component.window);
    }


    protected handleTargetSelf(viewEvent: ViewEvent, html: string) {
        history.replaceState({}, '', viewEvent.url);
        this.handleTargetAction(viewEvent, html);
    }


    private injectJs(response: Response) {
        const jsFiles = response.headers.get('inject-js');

        if (jsFiles) {
            const jsFilesList = jsFiles.split(", ");

            jsFilesList.forEach(file => {
                if (!document.body.querySelector(`script[src='${file}']`)) {
                    const script = document.createElement('script');
                    script.src = file;
                    document.body.append(script);
                }
            });
        }
    }

    private injectCss(response: Response) {
        const cssFiles = response.headers.get('inject-css');
        if (cssFiles) {
            const cssFilesList = cssFiles.split(", ");
            cssFilesList.forEach(file => {
                if (!document.head.querySelector(`link[href='${file}']`)) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = file;
                    document.head.append(link);
                }
            });
        }
    }

}
