<p>
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/home.css">
    </head>

    <body class="font-sans text-gray-800">


        <section id="hero" class="py-20 px-4">
            <div class="container mx-auto text-center">
                <span class="badge variant-secondary mb-4">
                    Cuidando da sua saúde com excelência
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Atom <span class="text-blue-600">Fisioterapia</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Tratamentos personalizados com tecnologia de ponta e profissionais especializados para sua recuperação e
                    bem-estar.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= baseUrl() ?>Sessao/form/insert/0" class="inline-block">
                        <button class="button bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                                <path d="M8 2V4"></path>
                                <path d="M16 2V4"></path>
                                <path d="M21 13V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path>
                                <path d="M3 10h18"></path>
                                <path d="M19 16v6"></path>
                                <path d="M16 19h6"></path>
                            </svg>
                            Agendar Consulta
                        </button>
                    </a>
                    <button class="button variant-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Falar Conosco
                    </button>
                </div>
            </div>
        </section>

        <section class="py-16 px-4 bg-white">
            <div class="container mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">500+</div>
                        <div class="text-gray-600">Pacientes Atendidos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">15+</div>
                        <div class="text-gray-600">Profissionais</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">5</div>
                        <div class="text-gray-600">Anos de Experiência</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">98%</div>
                        <div class="text-gray-600">Satisfação</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="servicos" class="py-20 px-4">
            <div class="container mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Nossos Serviços</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Oferecemos uma ampla gama de tratamentos especializados para sua recuperação
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Fisioterapia Ortopédica</h3>
                            <p class="text-gray-600">Tratamento de lesões musculoesqueléticas e reabilitação pós-cirúrgica</p>
                        </div>
                    </div>
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Fisioterapia Neurológica</h3>
                            <p class="text-gray-600">Reabilitação de pacientes com distúrbios neurológicos</p>
                        </div>
                    </div>
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="m15.477 12.892 1.637 1.636L16 16l-3-3 1.636 1.637a2 2 0 0 1-.168 2.83l-2.291 2.291c-.6.6-1.545.636-2.11.084L7.293 20.7a2 2 0 0 1-2.828-2.828l1.01-1.01c-.552-.565-.516-1.509.084-2.11l2.291-2.291a2 2 0 0 1 2.83-.168L12 13l3-3 1.636 1.637a2 2 0 0 1-.159 2.83z"></path>
                                    <path d="M17.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                    <path d="M3.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                    <path d="M7 5h.01"></path>
                                    <path d="M17 5h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Fisioterapia Respiratória</h3>
                            <p class="text-gray-600">Tratamento de disfunções do sistema respiratório</p>
                        </div>
                    </div>
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">RPG</h3>
                            <p class="text-gray-600">Reeducação Postural Global para correção de desvios posturais</p>
                        </div>
                    </div>
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Pilates Clínico</h3>
                            <p class="text-gray-600">Exercícios terapêuticos para fortalecimento e flexibilidade</p>
                        </div>
                    </div>
                    <div class="card hover:shadow-lg">
                        <div class="card-content">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-blue-600">
                                    <path d="m15.477 12.892 1.637 1.636L16 16l-3-3 1.636 1.637a2 2 0 0 1-.168 2.83l-2.291 2.291c-.6.6-1.545.636-2.11.084L7.293 20.7a2 2 0 0 1-2.828-2.828l1.01-1.01c-.552-.565-.516-1.509.084-2.11l2.291-2.291a2 2 0 0 1 2.83-.168L12 13l3-3 1.636 1.637a2 2 0 0 1-.159 2.83z"></path>
                                    <path d="M17.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                    <path d="M3.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                    <path d="M7 5h.01"></path>
                                    <path d="M17 5h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">Acupuntura</h3>
                            <p class="text-gray-600">Técnica milenar para alívio da dor e bem-estar</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="sobre" class="py-20 px-4 bg-white">
            <div class="container mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Sobre a Atom Fisioterapia</h2>
                        <p class="text-gray-600 mb-6">
                            Fundada com o compromisso de oferecer tratamentos de fisioterapia de alta qualidade, a Atom Fisioterapia
                            combina técnicas tradicionais com tecnologia moderna para proporcionar os melhores resultados aos nossos
                            pacientes.
                        </p>
                        <p class="text-gray-600 mb-8">
                            Nossa equipe multidisciplinar é formada por profissionais especializados e comprometidos com a
                            excelência no atendimento, sempre focados na recuperação e bem-estar de cada paciente.
                        </p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-yellow-400 fill-current">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-yellow-400 fill-current">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-yellow-400 fill-current">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-yellow-400 fill-current">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-yellow-400 fill-current">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                            <span class="text-gray-600">4.9/5 - Avaliação dos pacientes</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl p-8">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                        <path d="m15.477 12.892 1.637 1.636L16 16l-3-3 1.636 1.637a2 2 0 0 1-.168 2.83l-2.291 2.291c-.6.6-1.545.636-2.11.084L7.293 20.7a2 2 0 0 1-2.828-2.828l1.01-1.01c-.552-.565-.516-1.509.084-2.11l2.291-2.291a2 2 0 0 1 2.83-.168L12 13l3-3 1.636 1.637a2 2 0 0 1-.159 2.83z"></path>
                                        <path d="M17.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                        <path d="M3.5 11c.974.7 1.948 1.4 2.922 2.1"></path>
                                        <path d="M7 5h.01"></path>
                                        <path d="M17 5h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold">Certificações</h3>
                                    <p class="text-gray-600">Profissionais certificados e especializados</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold">Cuidado Personalizado</h3>
                                    <p class="text-gray-600">Tratamentos adaptados às suas necessidades</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold">Horários Flexíveis</h3>
                                    <p class="text-gray-600">Atendimento de segunda a sábado</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contato" class="py-20 px-4">
            <div class="container mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Entre em Contato</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Estamos prontos para cuidar da sua saúde. Agende sua consulta hoje mesmo.
                    </p>
                </div>
                <div class="grid lg:grid-cols-3 gap-8">
                    <div class="card text-center p-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold">Telefone</h3>
                            <p class="text-gray-600">(11) 9999-9999</p>
                            <p class="text-gray-600">(11) 3333-3333</p>
                        </div>
                    </div>
                    <div class="card text-center p-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold">E-mail</h3>
                            <p class="text-gray-600">contato@atomfisio.com.br</p>
                            <p class="text-gray-600">agendamento@atomfisio.com.br</p>
                        </div>
                    </div>
                    <div class="card text-center p-6">
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-white">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <h3 class="font-semibold">Endereço</h3>
                            <p class="text-gray-600">Rua das Flores, 123</p>
                            <p class="text-gray-600">São Paulo - SP</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>

    </html>
</p>