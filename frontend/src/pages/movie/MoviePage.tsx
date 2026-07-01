import { useEffect, useMemo, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { getMovie, getShowtimes, type Movie, type Showtime } from '../../api/cinema'
import { Page } from '../../components/Page'

export function MoviePage() {
  const { movieId } = useParams()
  const parsedMovieId = Number(movieId)
  const [movie, setMovie] = useState<Movie | null>(null)
  const [showtimes, setShowtimes] = useState<Showtime[]>([])
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    if (!Number.isFinite(parsedMovieId)) {
      return
    }

    Promise.all([getMovie(parsedMovieId), getShowtimes()])
      .then(([movieData, showtimeData]) => {
        setMovie(movieData)
        setShowtimes(showtimeData.filter((showtime) => showtime.movie_id === parsedMovieId))
      })
      .finally(() => setIsLoading(false))
  }, [parsedMovieId])

  const showtimesByHall = useMemo(() => {
    return showtimes.reduce<Record<number, { hallName: string; showtimes: Showtime[] }>>(
      (groups, showtime) => {
        const hallId = showtime.hall_id
        groups[hallId] ??= {
          hallName: showtime.hall?.name ?? `Зал ${hallId}`,
          showtimes: [],
        }
        groups[hallId].showtimes.push(showtime)

        return groups
      },
      {},
    )
  }, [showtimes])

  if (isLoading) {
    return <Page>Загрузка...</Page>
  }

  if (!movie) {
    return <Page>Фильм не найден</Page>
  }

  return (
    <Page>
      <Link className="back-link" to="/">
        <i className="ri-arrow-left-line" aria-hidden="true" />
        Назад к фильмам
      </Link>

      <article className="movie-detail">
        <img className="movie-detail__poster" src={movie.image_url ?? ''} alt="" />
        <div className="movie-detail__content">
          <p className="text-label">
            <i className="ri-time-line" aria-hidden="true" />
            {movie.duration} мин.
          </p>
          <h1>{movie.title}</h1>
          <p>{movie.description}</p>
        </div>
      </article>

      <section className="hall-showtimes">
        {Object.entries(showtimesByHall).map(([hallId, group]) => (
          <div className="hall-showtimes__block" key={hallId}>
            <h2>
              <i className="ri-building-4-line" aria-hidden="true" />
              {group.hallName}
            </h2>
            <div className="showtime-buttons">
              {group.showtimes.map((showtime) => (
                <Link className="showtime-button" to={`/showtimes/${showtime.id}`} key={showtime.id}>
                  <i className="ri-calendar-event-line" aria-hidden="true" />
                  {formatDateTime(showtime.starts_at)}
                </Link>
              ))}
            </div>
          </div>
        ))}
      </section>
    </Page>
  )
}

function formatDateTime(value: string) {
  return new Intl.DateTimeFormat('ru-RU', {
    day: '2-digit',
    month: 'long',
    hour: '2-digit',
    minute: '2-digit',
  }).format(new Date(value))
}
