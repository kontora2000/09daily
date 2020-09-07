export default {
  sanitizeString (s) {
    s = s.replace(/\s+/g, ' ')
    s = s.replace(/#+/g, '#')
    s = s.replace(/@+/g, '@')
    s = s.replace('`', '')
    s = s.replace(/(<([^>]+)>)/ig, '')
    return s.toLowerCase()
  },
  parseString (s) {
    if (s.trim() === '') { return false }

    const w = this.stringToWords(s)
    const b = this.parseWords(w)
    const restSearchString = this.blocksToRestString(w)
    return {
      restString: restSearchString,
      blocks: b,
      words: w
    }
  },
  stringToWords (s) {
    if (s.trim() === '') { return [] }
    const inputString = this.sanitizeString(s)
    const w = inputString.split(' ')
    return w.filter(w => w.trim() !== '')
  },
  blocksToRestString (b) {
    const fullString = []
    const tags = []
    const authors = []
    b = Array.from(new Set(b))
    for (const block of b) {
      if (block[0] === '#') {
        tags.push(block.replace('#', ''))
        continue
      }
      if (block[0] === '@') {
        authors.push(block.replace('@', ''))
        continue
      }
      fullString.push(block)
    }
    let restSearchString = '/s?'

    if (fullString.length > 0) {
      restSearchString += ('&w=' + fullString.join(','))
    }

    if (tags.length > 0) {
      restSearchString += ('&t=' + tags.join(','))
    }

    if (authors.length > 0) {
      restSearchString += ('&a=' + authors.join(','))
    }
    if (restSearchString === 's?') { return false }

    return restSearchString
  },
  parseWords (w) {
    let phrase = ''
    const blocks = []
    w = Array.from(new Set(w))
    for (const word of w) {
      if (word[0] === '#') {
        if (phrase !== '') {
          blocks.push(phrase)
          phrase = ''
        }
        blocks.push(word)
        continue
      }
      if (word[0] === '@') {
        if (phrase !== '') {
          blocks.push(phrase)
          phrase = ''
        }
        blocks.push(word)
        continue
      }
      if (phrase === '') { phrase = word } else { phrase += (' ' + word) }
    }
    if (phrase !== '') { blocks.push(phrase) }
    return blocks
  },
  blocksToURLString (blocks) {
    return encodeURIComponent(JSON.stringify(blocks))
  },
  URLtoBlocks (url) {
    return JSON.parse(decodeURIComponent(url))
  }
}
