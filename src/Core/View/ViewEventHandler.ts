import './ViewEvent.scss';
import ViewEvent from "./ViewEvent";

export default class ViewEventHandler {
    public init(element: HTMLElement)
    {
        element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this));
    }

    protected initEvent(element: HTMLElement)
    {
        const viewEvent = new ViewEvent(element.dataset);
        const target = document.getElementById(viewEvent.handler);
        if (target) {
            element.addEventListener(viewEvent.event, event => {
                event.preventDefault();
                const url = new URL(viewEvent.url, document.baseURI);
                if (viewEvent.handler) {
                    url.searchParams.append('handler', viewEvent.handler);
                }
                fetch(url.toString()).then(r => r.text()).then(html => {
                    if (html) {
                        const tmpDiv = document.createElement('div');
                        tmpDiv.innerHTML = html.trim();
                        const htmlElement = tmpDiv.firstElementChild as HTMLElement;
                        this.init(htmlElement);
                        target.replaceWith(htmlElement);
                        history.replaceState({}, '', viewEvent.url);
                    }
                });
            });
        }

    }
}