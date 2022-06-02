import './Number.scss'
import ViewDivElement from '../ViewDivElement'

class Number extends ViewDivElement {
  private decrease: HTMLButtonElement
  private increase: HTMLButtonElement;
  private field: HTMLInputElement;
  constructor () {
    super()
    this.decrease = this.querySelector('.number__decrease') as HTMLButtonElement;
    this.increase = this.querySelector('.number__increase') as HTMLButtonElement;
    this.field = this.querySelector('.number__field') as HTMLInputElement;
    this.decrease.addEventListener('click', () => {
      this.field.valueAsNumber--;
      this.field.dispatchEvent(new InputEvent('change'))
    })
    this.increase.addEventListener('click', () => {
      this.field.valueAsNumber++;
      this.field.dispatchEvent(new InputEvent('change'))
    })
  }
}

customElements.define('core-number', Number, { extends: 'div' })