export default class ViewMessage implements IViewMessage{
  public code: string;
  public id: string|null;
  public html: string|null;
  public data;

  constructor (code: string, data = null) {
    this.code = code
    this.data = data
  }
}