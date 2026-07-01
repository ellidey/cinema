import { Link } from 'react-router-dom'
import { Page } from '../../components/Page'

export function ShowtimesPage() {
  return (
    <Page>
      <Link to="/" className="showtimes-back-link">
        Назад
      </Link>

      <section className="showtimes-empty-state">
        <p className="text-label">Следующий этап</p>
        <h1>Здесь будет список сеансов</h1>
        <p>Маршрут готов для таблицы сеансов, бронирования и формы оплаты.</p>
      </section>
    </Page>
  )
}
