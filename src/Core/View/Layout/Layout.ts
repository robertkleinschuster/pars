import './Layout.scss'
import ViewHtmlElement from '../ViewHtmlElement'
import ViewInjector from '../ViewInjector'

export default class Layout extends ViewHtmlElement {

  constructor () {
    super()
    const url = new URL(window.location.href, document.baseURI);
    url.protocol = 'ws';
    const socket = new WebSocket(url);

    socket.onopen = () => {
      socket.send('Layout');
    };
    socket.onerror = (e) => {
      console.error(e)
    }
    socket.onmessage = (data) => {
      console.log(data);
    };
  }
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
