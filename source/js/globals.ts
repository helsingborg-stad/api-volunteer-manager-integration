import { GdiHostInterface } from './gdi-host/api'

declare global {
  interface Window {
    gdiHost: GdiHostInterface
  }
}
