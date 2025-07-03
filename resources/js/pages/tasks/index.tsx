import React, { useState } from 'react'
import { useForm } from '@inertiajs/react'
import { router } from '@inertiajs/react'
import axios from 'axios';

type Task = {
    id: number
    name: string
    priority: string
    status: string
    due_date: string
}

interface PageProps {
    tasks: Task[]
}

export default function Index({ tasks }: PageProps) {
    const [publicLink, setPublicLink] = useState<string | null>(null)

    const { data, setData, post, processing, reset, errors } = useForm({
        name: '',
        description: '',
        priority: 'medium',
        status: 'to-do',
        due_date: ''
    })

    const submit = (e: React.FormEvent) => {
        e.preventDefault()
        post('/tasks', {
            onSuccess: () => {
                reset()
            }
        })
    }

    const shareTask = async (taskId: number) => {
        try {
            const response = await axios.post(`/tasks/${taskId}/share`)
            setPublicLink(response.data.public_link)
        } catch (error) {
            alert('Błąd podczas udostępniania zadania')
        }
    }

    return (
        <div className="p-4 max-w-2xl mx-auto">
            <h1 className="text-2xl font-bold mb-6">Twoje zadania</h1>

            {/* FORMULARZ DODAWANIA */}
            <form onSubmit={submit} className="mb-6 space-y-4 border p-4 rounded">
                <div>
                    <label>Nazwa zadania</label>
                    <input
                        type="text"
                        value={data.name}
                        onChange={e => setData('name', e.target.value)}
                        className="w-full border p-2"
                    />
                    {errors.name && <p className="text-red-500 text-sm">{errors.name}</p>}
                </div>

                <div>
                    <label>Opis</label>
                    <textarea
                        value={data.description}
                        onChange={e => setData('description', e.target.value)}
                        className="w-full border p-2"
                    />
                </div>

                <div className="flex gap-4">
                    <div>
                        <label>Priorytet</label>
                        <select
                            value={data.priority}
                            onChange={e => setData('priority', e.target.value)}
                            className="w-full border p-2"
                        >
                            <option value="low">Niski</option>
                            <option value="medium">Średni</option>
                            <option value="high">Wysoki</option>
                        </select>
                    </div>

                    <div>
                        <label>Status</label>
                        <select
                            value={data.status}
                            onChange={e => setData('status', e.target.value)}
                            className="w-full border p-2"
                        >
                            <option value="to-do">Do zrobienia</option>
                            <option value="in-progress">W trakcie</option>
                            <option value="done">Zrobione</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label>Termin</label>
                    <input
                        type="date"
                        value={data.due_date}
                        onChange={e => setData('due_date', e.target.value)}
                        className="w-full border p-2"
                    />
                    {errors.due_date && <p className="text-red-500 text-sm">{errors.due_date}</p>}
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="bg-green-600 text-white px-4 py-2 rounded"
                >
                    Dodaj zadanie
                </button>
            </form>

            {/* LISTA ZADAŃ */}
            <ul>
                {tasks.map(task => (
                    <li key={task.id} className="mb-2 border p-3 rounded">
                        <div className="flex justify-between items-center">
                            <div>
                                <strong>{task.name}</strong> – {task.status} – {task.due_date}
                            </div>
                            <button
                                onClick={() => shareTask(task.id)}
                                className="bg-blue-500 text-white px-2 py-1 rounded"
                            >
                                Udostępnij
                            </button>
                        </div>
                    </li>
                ))}
            </ul>

            {publicLink && (
                <div className="mt-4 bg-green-100 border p-3 rounded">
                    <strong>Publiczny link:</strong>{' '}
                    <a href={publicLink} target="_blank" className="underline text-blue-600">
                        {publicLink}
                    </a>
                </div>
            )}
        </div>
    )
}
