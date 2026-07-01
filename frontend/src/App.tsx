import { Route, Routes } from 'react-router-dom'
import { HomePage } from './pages/home/HomePage'
import { ShowtimesPage } from './pages/showtimes/ShowtimesPage'

export function App() {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/showtimes" element={<ShowtimesPage />} />
    </Routes>
  )
}
