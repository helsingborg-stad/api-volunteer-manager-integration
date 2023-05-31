import React from 'react'

export type PhraseFn = (key: string, defaultPhrase: string) => string

export interface PhraseContextInterface {
  phrase: PhraseFn
}

const PhraseContext = React.createContext<PhraseContextInterface>({
  phrase: (key: string, defaultPhrase: string) => defaultPhrase,
})

export default PhraseContext
