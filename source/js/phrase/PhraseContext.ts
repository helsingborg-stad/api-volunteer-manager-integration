import React from 'react'

export type PhraseFn = (key: string, defaultPhrase: string) => string

export interface PhraseContext {
  phrase: PhraseFn
}

const PhraseContext = React.createContext<PhraseContext>({
  phrase: (key: string, defaultPhrase: string) => defaultPhrase,
})

export default PhraseContext
