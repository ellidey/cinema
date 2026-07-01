import { Link } from 'react-router-dom'
import { useEffect, useState } from 'react'
import { getMovies, type Movie } from '../../api/cinema'
import { Page } from '../../components/Page'

export function HomePage() {
  const [movies, setMovies] = useState<Movie[]>([])
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    getMovies()
      .then(setMovies)
      .finally(() => setIsLoading(false))
  }, [])

  return (
    <Page>
      <section className="home-hero">
        <p className="text-label">
          <i className="ri-movie-2-line" aria-hidden="true" />
          Cinema tickets
        </p>
        <h1>Фильмы</h1>
      </section>

      {isLoading ? (
        <p className="loading-text">Загрузка...</p>
      ) : (
        <section className="movie-grid">
          {movies.map((movie) => (
            <Link className="movie-card" to={`/movies/${movie.id}`} key={movie.id}>
              <img src={movie.image_url ?? ''} alt="" />
              <div>
                <p className="text-label">
                  <i className="ri-time-line" aria-hidden="true" />
                  {movie.duration} мин.
                </p>
                <h2>{movie.title}</h2>
                <p>{movie.description}</p>
              </div>
            </Link>
          ))}
        </section>
      )}
    </Page>
  )
}
