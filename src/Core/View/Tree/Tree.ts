import './Tree.scss'
import Search from '../Search/Search'
import { Similar } from '../Search/SearchComparator'
import ViewUListElement from '../ViewUListElement'

class Tree extends ViewUListElement {
  private search: Search

  protected init (): void {
    const searchElement = this.querySelector('.search') as Search

    if (searchElement !== null) {
      this.search = searchElement
      this.search.elements = this.querySelectorAll('.tree__value')
      this.search.onSearch = this.onSearch.bind(this)
    }
    this.onclick = this.onClick.bind(this)
  }

  private onClick (event: Event) {
    event.stopImmediatePropagation()
    const target = event.target as HTMLElement
    if (target.closest('.tree__value') != null) {
      const itemElement = target.parentElement as HTMLElement
      const state = itemElement.classList.toggle('open')
      if (!state) {
        this.togglePath(itemElement, false)
      }
    }
  }

  private onSearch () {
    const foundElements = this.search.search(new Similar())
    foundElements.forEach(this.togglePath.bind(this))
    this.querySelectorAll('.tree__value')
      .forEach((elem: HTMLElement) => elem.classList.toggle('hidden', !foundElements.includes(elem)))
  }

  protected togglePath (element: HTMLElement, force = false) {
    if (element.parentElement != null) {
      const item = element.parentElement.closest('.tree__item') as HTMLElement
      if (item !== null) {
        item.classList.toggle('open', force)
        this.togglePath(item, force)
      }
    }
  }
}

customElements.define('core-tree', Tree, {extends: 'ul'})