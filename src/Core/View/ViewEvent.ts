export default class {
    public event: string;
    public url: string;
    public handler: string;


    constructor(data: object = {}) {
        for (const [key, value] of Object.entries(data)) {
            // @ts-ignore
            this[key] = value;
        }
    }
}