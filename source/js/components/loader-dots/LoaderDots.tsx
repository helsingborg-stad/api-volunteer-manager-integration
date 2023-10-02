import { useEffect, useState } from 'react'

export const LoaderDots: React.FC<{
  render: (dots: string) => React.ReactNode
  pattern?: string[]
  speed?: number
}> = ({ render, pattern = ['..', '...', '....'], speed = 400 }) => {
  const [index, setIndex] = useState(0)

  useEffect(() => {
    const timer = setInterval(() => {
      setIndex((prevIndex) => (prevIndex + 1) % pattern.length)
    }, speed)
    return () => clearInterval(timer)
  }, [pattern, speed])

  const dots = pattern[index]
  return <>{render(dots)}</>
}
