import ViewEventHandler from "./ViewEventHandler";
import ViewWindow from "./ViewWindow";

export default class ViewComponent {
    public url: URL;
    public element: HTMLElement;
    public window: ViewWindow;
    public eventHandler: ViewEventHandler;

    constructor(url: URL, element: HTMLElement, window: ViewWindow = null) {
        this.url = url;
        this.element = element;
        this.window = window;
        this.eventHandler = new ViewEventHandler(this);
    }

    public init()
    {
        this.eventHandler.init();
    }

}