import './Overview.scss'
import ViewDivElement from '../ViewDivElement'

class OverviewElement extends ViewDivElement {
  constructor () {
    super()
    this.initSortColumn()
  }

  private initSortColumn () {
    const headers = this.querySelectorAll('th')

    headers.forEach((th, index) =>
      th.addEventListener('click', this.sortColumn.bind(this, th, index)))
  }

  private sortColumn (th: HTMLTableCellElement, index: number) {
    const headers = this.querySelectorAll('th')
    headers.forEach((th, i) => {
      if (i != index) {
        delete th.dataset.direction;
      }
    });

    if (th.dataset.direction == null) {
      th.dataset.direction = String(1)
    }
    const direction = Number.parseInt(th.dataset.direction)
    th.dataset.direction = String(direction * -1)

    const tableBody = this.querySelector('tbody') as HTMLElement
    const rows = tableBody.querySelectorAll('tr')
    const newRows = Array.from(rows)

    newRows.sort((rowA, rowB) => {
      const cellA = rowA.querySelectorAll('td')[index].innerHTML
      const cellB = rowB.querySelectorAll('td')[index].innerHTML
      if (cellA > cellB) {
        return direction
      }
      if (cellA < cellB) {
        return -1 * direction
      }
      return 0
    })

    rows.forEach(row => row.remove())
    newRows.forEach(row => tableBody.appendChild(row))
  }
}

customElements.define('core-overview', OverviewElement, { extends: 'div' })
