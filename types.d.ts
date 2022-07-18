interface IViewMessage {
  code: string;
  id: string | null;
  html: string | null;
  data;
}

interface IViewHelper {
  on (code: string, listener: (message: IViewMessage) => void)

  dispatch (message: string | IViewMessage | Event)
}

interface HTMLElement {
  dispatch (e: Event): void

  getHelper (): IViewHelper;

  _helper: IViewHelper | null;
}

