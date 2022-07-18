import './Layout.scss'
import ViewInjector from '../ViewInjector'

export default class Layout extends HTMLHtmlElement {

}

customElements.define('core-layout', Layout, { extends: 'html' })

const styles = document.getElementById('additional-css') as HTMLTemplateElement
if (null !== styles && null !== styles.content) {
  const viewInjector = new ViewInjector()
  viewInjector.injectCss(styles.content)
  styles.remove()
}

