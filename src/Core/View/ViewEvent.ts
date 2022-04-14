import './ViewEvent.scss'

export default class {
  public static readonly TARGET_SELF = 'self'
  public static readonly TARGET_ACTION = 'action'
  public static readonly TARGET_BLANK = 'blank'
  public static readonly TARGET_WINDOW = 'window'

  public event: string
  public target: string
  public url: string
  public title: string = ''
  public method: string = 'GET'

  constructor (data: object = {}) {
    for (const [key, value] of Object.entries(data)) {
      this[key] = value
    }
  }

  public getParams()
  {
    const params = new Map();
    for (const [key, value] of Object.entries(this)) {
      if (key.startsWith('param')) {
        params.set(key.substring("param".length).toLowerCase(), value);
      }
    }
    return params;
  }
}
