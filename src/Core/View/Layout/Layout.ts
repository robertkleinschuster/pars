import './Layout.scss'
import ViewHtmlElement from '../ViewHtmlElement'
import ViewInjector from '../ViewInjector'

export default class Layout extends ViewHtmlElement {

}

customElements.define('core-layout', Layout, { extends: 'html' })

const styles = document.getElementById('additional-css') as HTMLTemplateElement
if (null !== styles && null !== styles.content) {
  const viewInjector = new ViewInjector()
  viewInjector.injectCss(styles.content)
  styles.remove()
}

let level = 0
const loader = document.createElement('div')
loader.classList.add('loader')
window.fetch = new Proxy(window.fetch, {
  apply (fetch, that, args) {
    if (level === 0) {
      document.body.prepend(loader)
    }
    document.documentElement.classList.add('loading')
    level++
    return fetch.apply(that, args).then(r => {
      if (0 === --level) {
        document.documentElement.classList.remove('loading')
        loader.remove()
      }
      return r
    })
  }
})
