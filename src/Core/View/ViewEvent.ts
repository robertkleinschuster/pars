export default class {
    public event: string;
    public url: string;
    public handler: string;
    public target: string;
    public title: string = '';

    constructor(data: object = {}) {
        for (const [key, value] of Object.entries(data)) {
            // @ts-ignore
            this[key] = value;
        }
    }
}
