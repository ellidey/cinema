import { Route, Routes } from 'react-router-dom'
import { HomePage } from './pages/home/HomePage'
import { MoviePage } from './pages/movie/MoviePage'
import { NotFoundPage } from './pages/not-found/NotFoundPage'
import { ShowtimePage } from './pages/showtime/ShowtimePage'

export function App() {
  return (
    <Routes>
      <Route path="/" element={<HomePage />} />
      <Route path="/movies/:movieId" element={<MoviePage />} />
      <Route path="/showtimes/:showtimeId" element={<ShowtimePage />} />
      <Route path="*" element={<NotFoundPage />} />
    </Routes>
  )
}
