import './ViewEvent.scss';

export default class {
    public static readonly TARGET_SELF = 'self';
    public static readonly TARGET_ACTION = 'action';
    public static readonly TARGET_BLANK = 'blank';
    public static readonly TARGET_WINDOW = 'window';

    public event: string;
    public target: string;
    public url: string;
    public title: string = '';

    constructor(data: object = {}) {
        for (const [key, value] of Object.entries(data)) {
            // @ts-ignore
            this[key] = value;
        }
    }
}
