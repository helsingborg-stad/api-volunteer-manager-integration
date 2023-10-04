export const capitalizeName = (name: string) =>
  name
    .split(/([\s-])/) // Keep the delimiters in the result.
    .map((word: string, index: number) =>
      index % 2 === 0 // Only capitalize words, not delimiters.
        ? word.charAt(0).toUpperCase() + word.substring(1).toLowerCase()
        : word,
    )
    .join('')
