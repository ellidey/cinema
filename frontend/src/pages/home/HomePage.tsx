import { Link } from 'react-router-dom'
import { useSystemHealth } from '../../api/systemHealth'
import { Page } from '../../components/Page'
import { StatusGrid } from '../../components/StatusGrid'

export function HomePage() {
  const apiHealth = useSystemHealth()

  return (
    <Page>
      <section className="home-hero">
        <p className="text-label">Cinema tickets</p>
        <h1>Laravel API + React client</h1>
        <p>
          Базовая структура для тестового задания по бронированию билетов.
          React отдается nginx на <code>localhost</code>, Laravel отвечает через
          <code>/api</code>.
        </p>
      </section>

      <StatusGrid
        items={[
          {
            label: 'Frontend',
            value: 'React + TypeScript',
          },
          {
            label: 'Backend',
            value: apiHealth.data
              ? `${apiHealth.data.service}: ${apiHealth.data.status}`
              : apiHealth.error ?? 'Проверка...',
          },
          {
            label: 'Router',
            value: <Link to="/showtimes">Открыть маршрут сеансов</Link>,
          },
        ]}
      />
    </Page>
  )
}
