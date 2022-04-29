import './Search.scss'
import { SearchComparator } from './SearchComparator'
import ViewDivElement from '../ViewDivElement'

export default class Search extends ViewDivElement {
  private input: HTMLInputElement
  private button: HTMLButtonElement
  public elements: NodeListOf<HTMLElement>

  private _onSearch: (search: Search) => void

  protected init () {
    this.input = this.querySelector('input') as HTMLInputElement
    this.button = this.querySelector('button') as HTMLButtonElement
    this.input.addEventListener('keyup', this.onInput.bind(this))
    this.input.addEventListener('keydown', this.onInput.bind(this))
  }

  set onSearch (value: (search: Search) => void) {
    this._onSearch = value
  }

  private onInput () {
    this._onSearch(this)
  }

  public search (comparator: SearchComparator) {
    const keyword = this.input.value
    return Array.from(this.elements).filter(element => {
      return comparator.compare(element.innerText, keyword)
    })
  }
}

customElements.define('core-search', Search, { extends: 'div' })
