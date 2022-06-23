export default class ViewInjector {
  public injectCss (root: ParentNode) {
    root.querySelectorAll('link.css').forEach((l: HTMLLinkElement) => {
      const href = l.getAttribute('href')
      if (null === href) {
        return
      }
      if (document.querySelector(`link.css[href='${href}']`) == null) {
        const link = document.createElement('link')
        link.rel = 'stylesheet'
        link.classList.add('css')
        link.href = href
        document.head.append(link)
      }
    })
  }

  public injectJs(root: ParentNode)
  {
    root.querySelectorAll('script.script').forEach((s: HTMLScriptElement) => {
      const src = s.getAttribute('src')
      if (null === src) {
        return
      }
      if (document.querySelector(`script.script[src='${src}']`) == null) {
        const script = document.createElement('script')
        script.classList.add('script')
        script.src = src
        document.body.append(script)
      }
    })
  }


}