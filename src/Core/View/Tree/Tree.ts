import './Tree.scss'
import ViewComponent from '../ViewComponent'
import WebComponent from '../WebComponent'
import ViewEvent from '../ViewEvent'

class Tree extends ViewComponent {
  private search: HTMLInputElement

  protected init (): void {
    super.init()
    this.search = this.element.querySelector('.tree__search input') as HTMLInputElement
    if (null !== this.search) {
      this.search.addEventListener('keyup', this.onSearch.bind(this))
      this.search.addEventListener('keydown', this.onSearch.bind(this))
    }
    this.element.querySelectorAll('.tree__item').forEach(item => {
      item.addEventListener('click', event => {
        const state = (event.currentTarget as HTMLElement).classList.toggle('open')
        if (!state) {
          (event.currentTarget as HTMLElement).querySelectorAll('.tree__item').forEach(element => {
            element.classList.remove('open')
          })
        }
        event.stopImmediatePropagation()
      })
    })
  }

  protected onSearch () {
    let found = false
    this.element.querySelectorAll('.tree__value').forEach((item: HTMLElement) => {
      this.togglePath(item, false)
      item.classList.remove('hidden')
      if ('' !== this.search.value.trim()) {
        if (item.innerText.includes(this.search.value)
          || undefined !== item.dataset.url && item.dataset.url.includes(this.search.value)) {
          this.togglePath(item, true)
          found = true
        } else {
          item.classList.add('hidden')
        }
      }
    })
    if ('' === this.search.value.trim()) {
      found = true
      const active = this.element.querySelector('.tree__value.active') as HTMLElement
      if (null !== active) {
        this.togglePath(active, true)
        active.classList.remove('hidden')
      }
    }
    const searchWrap = this.element.querySelector('.tree__search') as HTMLElement
    if (found) {
      const createButton = searchWrap.querySelector('button')
      if (createButton) {
        createButton.remove()
      }
    } else {
      if (!searchWrap.querySelector('button')) {
        const createButton = document.createElement('button')
        createButton.innerText = '+'
        searchWrap.append(createButton)
        createButton.addEventListener('click', this.create.bind(this))
      }
    }
  }

  protected create () {
    if (undefined !== this.element.dataset.baseUri) {
      const viewEvent = new ViewEvent()
      viewEvent.url = this.element.dataset.baseUri + this.search.value
      viewEvent.target = ViewEvent.TARGET_SELF
      viewEvent.method = 'POST'
      this.eventHandler.trigger(viewEvent)
    }
  }

  protected togglePath (element: HTMLElement, force = false) {
    if (element.parentElement) {
      const item = element.parentElement.closest('.tree__item') as HTMLElement
      if (null !== item) {
        item.classList.toggle('open', force)
        this.togglePath(item, force)
      }
    }
  }
}

WebComponent.defineExtended(Tree, HTMLUListElement)

