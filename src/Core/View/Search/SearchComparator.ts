export interface SearchComparator {
  compare (value: string, keyword: string): boolean;
}

export class Includes implements SearchComparator {
  compare (value: string, keyword: string): boolean {
    return value.includes(keyword)
  }
}

export class Equals implements SearchComparator {
  compare (value: string, keyword: string): boolean {
    return value === keyword
  }

}

export class Similar implements SearchComparator {
  compare (value: string, keyword: string): boolean {

    const first = value.replace(/\s+/g, '')
    const second = keyword.replace(/\s+/g, '')

    if (first == second) return true // identical or empty
    if (first.length < 2 || second.length < 2) {
      return first.includes(second)
    }

    const firstBigrams = new Map()
    for (let i = 0; i < first.length - 1; i++) {
      const bigram = first.substring(i, i + 2)
      const count = firstBigrams.has(bigram)
        ? firstBigrams.get(bigram) + 1
        : 1

      firstBigrams.set(bigram, count)
    }

    let intersectionSize = 0
    for (let i = 0; i < second.length - 1; i++) {
      const bigram = second.substring(i, i + 2)
      const count = firstBigrams.has(bigram)
        ? firstBigrams.get(bigram)
        : 0

      if (count > 0) {
        firstBigrams.set(bigram, count - 1)
        intersectionSize++
      }
    }

    const similarity = (2.0 * intersectionSize) / (first.length + second.length - 2)

    return similarity >= .5
  }
}