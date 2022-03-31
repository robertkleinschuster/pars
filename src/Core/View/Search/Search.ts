import "./Search.scss"
import ViewComponent from '../ViewComponent'
import WebComponent from '../WebComponent'
import { SearchComparator } from './SearchComparator'

export default class Search extends ViewComponent {
  private input: HTMLInputElement
  private button: HTMLButtonElement
  public elements: NodeListOf<HTMLElement>

  private _onSearch: (search: Search) => void

  protected init () {
    super.init()
    this.input = this.element.querySelector('input') as HTMLInputElement
    this.button = this.element.querySelector('button') as HTMLButtonElement
    this.input.addEventListener('keyup', this.onInput.bind(this))
    this.input.addEventListener('keydown', this.onInput.bind(this))

  }

  set onSearch (value: (search: Search) => void) {
    this._onSearch = value
  }

  private onInput () {
    this._onSearch(this);
  }

  public search (comparator: SearchComparator) {
    const keyword = this.input.value
    return Array.from(this.elements).filter(element => {
      return comparator.compare(element.innerText, keyword)
    })
  }
}

WebComponent.define(Search, HTMLDivElement)