import "winbox";
import "winbox/dist/css/themes/modern.min.css"
import ViewEvent from "./ViewEvent";

declare const WinBox: WinBox.WinBoxConstructor;

export default class ViewWindow extends WinBox {
    protected parent: ViewWindow;
    protected viewEvent: ViewEvent;

    constructor(viewEvent: ViewEvent, html: string, parent: ViewWindow = null) {
        super({
            title: viewEvent.title, html: html, x: 'center', y: 'center', class: "modern",
        });
        this.parent = parent;
        this.viewEvent = new ViewEvent(viewEvent);
        this.viewEvent.target = 'self';
        this.body.dispatchEvent(new CustomEvent('init', {
            bubbles: true,
            detail: {
                url: new URL(viewEvent.url, document.baseURI)
            }
        }));
    }

    public reload() {

    }

    onclose = (force: boolean) => {

        return false;
    };

}
