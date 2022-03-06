export default class ViewHtmlHelper {
    public element: HTMLElement;

    constructor(element: HTMLElement) {
        this.element = element;
    }

    public find(selectors: string): HTMLElement[] {
        const elements: Element[] = [];
        if (this.element.matches(selectors)) {
            elements.push(this.element);
        } else {
            elements.push(...Array.from(this.element.querySelectorAll(selectors)));
        }
        return elements as HTMLElement[];
    }

    public findOne(selectors: string): HTMLElement|null
    {
        const elements = this.find(selectors);
        if (elements.length) {
            return elements.shift() as HTMLElement;
        }
        return null;
    }

    public first(): HTMLElement|null
    {
        return this.element.firstElementChild as HTMLElement;
    }

    public static fromString(html: string): ViewHtmlHelper
    {
        const element = document.createElement('div');
        element.innerHTML = html;
        return new this(element);
    }
}