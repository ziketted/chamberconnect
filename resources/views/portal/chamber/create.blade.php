@extends('layouts.app')

@section('title', 'Nouvelle demande de chambre')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
            <div class="p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-full">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Demande de Création de Chambre
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Remplissez ce formulaire pour soumettre votre demande de création d'une chambre de commerce
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300" id="step-label">
                            Étape 1 sur 3: Informations générales
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400" id="step-progress">33%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 33%"></div>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('portal.chamber.store') }}" enctype="multipart/form-data" id="chamber-form">
                    @csrf

                    <!-- Étape 1: Informations générales -->
                    <div class="step-content" id="step-1">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Informations générales
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom complet -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom complet de la chambre *
                                </label>
                                <input type="text" name="name" id="name" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Ex: Chambre de Commerce et d'Industrie du Haut-Katanga"
                                    value="{{ old('name') }}">
                                @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sigle -->
                            <div>
                                <label for="sigle" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sigle (abréviation) *
                                </label>
                                <input type="text" name="sigle" id="sigle" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Ex: CCIHK" value="{{ old('sigle') }}">
                                @error('sigle')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province/Ville -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Province / Ville du siège social *
                                </label>
                                <select name="location" id="location" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Sélectionnez une province</option>
                                    <option value="Kinshasa" {{ old('location')=='Kinshasa' ? 'selected' : '' }}>Kinshasa</option>
                                    <option value="Haut-Katanga" {{ old('location')=='Haut-Katanga' ? 'selected' : '' }}>Haut-Katanga</option>
                                    <option value="Lualaba" {{ old('location')=='Lualaba' ? 'selected' : '' }}>Lualaba</option>
                                    <option value="Haut-Lomami" {{ old('location')=='Haut-Lomami' ? 'selected' : '' }}>Haut-Lomami</option>
                                    <option value="Tanganyika" {{ old('location')=='Tanganyika' ? 'selected' : '' }}>Tanganyika</option>
                                    <option value="Sud-Kivu" {{ old('location')=='Sud-Kivu' ? 'selected' : '' }}>Sud-Kivu</option>
                                    <option value="Nord-Kivu" {{ old('location')=='Nord-Kivu' ? 'selected' : '' }}>Nord-Kivu</option>
                                    <option value="Ituri" {{ old('location')=='Ituri' ? 'selected' : '' }}>Ituri</option>
                                    <option value="Tshopo" {{ old('location')=='Tshopo' ? 'selected' : '' }}>Tshopo</option>
                                    <option value="Bas-Uele" {{ old('location')=='Bas-Uele' ? 'selected' : '' }}>Bas-Uele</option>
                                    <option value="Haut-Uele" {{ old('location')=='Haut-Uele' ? 'selected' : '' }}>Haut-Uele</option>
                                    <option value="Sankuru" {{ old('location')=='Sankuru' ? 'selected' : '' }}>Sankuru</option>
                                    <option value="Lomami" {{ old('location')=='Lomami' ? 'selected' : '' }}>Lomami</option>
                                    <option value="Kasaï" {{ old('location')=='Kasaï' ? 'selected' : '' }}>Kasaï</option>
                                    <option value="Kasaï-Central" {{ old('location')=='Kasaï-Central' ? 'selected' : '' }}>Kasaï-Central</option>
                                    <option value="Kasaï-Oriental" {{ old('location')=='Kasaï-Oriental' ? 'selected' : '' }}>Kasaï-Oriental</option>
                                    <option value="Kwango" {{ old('location')=='Kwango' ? 'selected' : '' }}>Kwango</option>
                                    <option value="Kwilu" {{ old('location')=='Kwilu' ? 'selected' : '' }}>Kwilu</option>
                                    <option value="Mai-Ndombe" {{ old('location')=='Mai-Ndombe' ? 'selected' : '' }}>Mai-Ndombe</option>
                                    <option value="Kongo-Central" {{ old('location')=='Kongo-Central' ? 'selected' : '' }}>Kongo-Central</option>
                                    <option value="Équateur" {{ old('location')=='Équateur' ? 'selected' : '' }}>Équateur</option>
                                    <option value="Mongala" {{ old('location')=='Mongala' ? 'selected' : '' }}>Mongala</option>
                                    <option value="Nord-Ubangi" {{ old('location')=='Nord-Ubangi' ? 'selected' : '' }}>Nord-Ubangi</option>
                                    <option value="Sud-Ubangi" {{ old('location')=='Sud-Ubangi' ? 'selected' : '' }}>Sud-Ubangi</option>
                                    <option value="Tshuapa" {{ old('location')=='Tshuapa' ? 'selected' : '' }}>Tshuapa</option>
                                    <option value="Maniema" {{ old('location')=='Maniema' ? 'selected' : '' }}>Maniema</option>
                                </select>
                                @error('location')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Adresse complète -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse complète *
                                </label>
                                <textarea name="address" id="address" rows="3" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Rue, quartier, commune, ville">{{ old('address') }}</textarea>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Téléphone de contact *
                                </label>
                                <input type="tel" name="phone" id="phone" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="+243 XXX XXX XXX" value="{{ old('phone') }}">
                                @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse e-mail officielle *
                                </label>
                                <input type="email" name="email" id="email" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="contact@exemple.org" value="{{ old('email') }}">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Site web -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Site web (facultatif)
                                </label>
                                <input type="url" name="website" id="website"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="https://www.exemple.org" value="{{ old('website') }}">
                                @error('website')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date de création -->
                            <div>
                                <label for="creation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Date de création *
                                </label>
                                <input type="date" name="creation_date" id="creation_date" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    value="{{ old('creation_date') }}">
                                @error('creation_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Objet social -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Objet social principal *
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Description claire du but de la chambre">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NINA -->
                            <div class="md:col-span-2">
                                <label for="nina_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Numéro d'identification nationale (NINA) *
                                </label>
                                <input type="text" name="nina_number" id="nina_number" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Numéro NINA" value="{{ old('nina_number') }}">
                                @error('nina_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2: Documents -->
                    <div class="step-content hidden" id="step-2">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Téléversement des documents
                        </h2>

                        <div class="space-y-6">
                            <!-- Statuts signés -->
                            <div>
                                <label for="statuts" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Statuts signés * <span class="text-xs text-gray-500">(PDF, DOCX - Max 10MB)</span>
                                </label>
                                <input type="file" name="statuts" id="statuts" accept=".pdf,.doc,.docx" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Document officiel indiquant l'objet, les organes, les règles internes</p>
                                @error('statuts')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Règlement intérieur -->
                            <div>
                                <label for="reglement_interieur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Règlement intérieur * <span class="text-xs text-gray-500">(PDF, DOCX - Max 10MB)</span>
                                </label>
                                <input type="file" name="reglement_interieur" id="reglement_interieur" accept=".pdf,.doc,.docx" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Complément des statuts</p>
                                @error('reglement_interieur')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- PV Assemblée constitutive -->
                            <div>
                                <label for="pv_assemblee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Procès-verbal de l'Assemblée constitutive * <span class="text-xs text-gray-500">(PDF - Max 10MB)</span>
                                </label>
                                <input type="file" name="pv_assemblee" id="pv_assemblee" accept=".pdf" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mentionne l'élection du bureau</p>
                                @error('pv_assemblee')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Liste des membres fondateurs -->
                            <div>
                                <label for="liste_membres" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Liste des membres fondateurs * <span class="text-xs text-gray-500">(PDF, Excel - Max 10MB)</span>
                                </label>
                                <input type="file" name="liste_membres" id="liste_membres" accept=".pdf,.xlsx,.xls" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Noms, fonctions, coordonnées, signatures</p>
                                @error('liste_membres')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Plan d'action -->
                            <div>
                                <label for="plan_action" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Plan d'action ou programme d'activités * <span class="text-xs text-gray-500">(PDF - Max 10MB)</span>
                                </label>
                                <input type="file" name="plan_action" id="plan_action" accept=".pdf" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Prévisions sur 1 à 3 ans</p>
                                @error('plan_action')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pièces d'identité -->
                            <div>
                                <label for="pieces_identite" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Copie des pièces d'identité des fondateurs * <span class="text-xs text-gray-500">(PDF - Max 20MB)</span>
                                </label>
                                <input type="file" name="pieces_identite" id="pieces_identite" accept=".pdf" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Carte d'identité ou passeport (fichier unique contenant toutes les pièces)</p>
                                @error('pieces_identite')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lettre de demande -->
                            <div>
                                <label for="lettre_demande" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Lettre de demande de personnalité juridique * <span class="text-xs text-gray-500">(PDF, DOCX - Max 10MB)</span>
                                </label>
                                <input type="file" name="lettre_demande" id="lettre_demande" accept=".pdf,.doc,.docx" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lettre adressée au Ministre de la Justice</p>
                                @error('lettre_demande')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3: Récapitulatif -->
                    <div class="step-content hidden" id="step-3">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            Récapitulatif et soumission
                        </h2>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informations saisies</h3>
                            <div id="summary-content" class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                <!-- Le contenu sera rempli par JavaScript -->
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Information importante</h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <p>Une fois votre demande soumise, elle sera examinée par nos administrateurs. Vous recevrez un e-mail de confirmation dès qu'une décision sera prise concernant votre demande.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" id="confirmation" required class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="confirmation" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                Je certifie que toutes les informations fournies sont exactes et que tous les documents requis ont été téléversés. *
                            </label>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="flex justify-between pt-6">
                        <button type="button" id="prev-btn" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 hidden">
                            Précédent
                        </button>
                        <button type="button" id="next-btn" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 ml-auto">
                            Suivant
                        </button>
                        <button type="button" id="submit-btn" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 ml-auto hidden">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Soumettre ma demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    const submitBtn = document.getElementById('submit-btn');
    const progressBar = document.getElementById('progress-bar');
    const stepLabel = document.getElementById('step-label');
    const stepProgress = document.getElementById('step-progress');

    function updateStep() {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.add('hidden');
        });

        // Show current step
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        // Update progress bar
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = progress + '%';
        stepProgress.textContent = Math.round(progress) + '%';

        // Update step label
        const stepLabels = {
            1: 'Étape 1 sur 3: Informations générales',
            2: 'Étape 2 sur 3: Documents requis',
            3: 'Étape 3 sur 3: Récapitulatif et soumission'
        };
        stepLabel.textContent = stepLabels[currentStep];

        // Update buttons
        if (currentStep === 1) {
            prevBtn.classList.add('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        } else if (currentStep === totalSteps) {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
            updateSummary();
        } else {
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }
    }

    function validateStep(step) {
        const currentStepElement = document.getElementById(`step-${step}`);
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (field.type === 'file') {
                if (!field.files.length) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            } else if (field.type === 'checkbox') {
                if (!field.checked) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            } else if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid && step < 3) {
            alert('Veuillez remplir tous les champs obligatoires avant de continuer.');
        }
        return isValid;
    }

    function updateSummary() {
        const summaryContent = document.getElementById('summary-content');
        const formData = new FormData(document.getElementById('chamber-form'));
        
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
        
        // Informations générales
        html += `
            <div><strong>Nom:</strong> ${formData.get('name') || 'Non renseigné'}</div>
            <div><strong>Sigle:</strong> ${formData.get('sigle') || 'Non renseigné'}</div>
            <div><strong>Province:</strong> ${formData.get('location') || 'Non renseigné'}</div>
            <div><strong>Téléphone:</strong> ${formData.get('phone') || 'Non renseigné'}</div>
            <div><strong>Email:</strong> ${formData.get('email') || 'Non renseigné'}</div>
            <div><strong>Site web:</strong> ${formData.get('website') || 'Non renseigné'}</div>
        `;
        
        html += '</div>';
        
        // Documents
        html += '<div class="mt-4"><strong>Documents téléversés:</strong><ul class="list-disc list-inside mt-2 space-y-1">';
        const documents = ['statuts', 'reglement_interieur', 'pv_assemblee', 'liste_membres', 'plan_action', 'pieces_identite', 'lettre_demande'];
        const documentLabels = {
            'statuts': 'Statuts signés',
            'reglement_interieur': 'Règlement intérieur',
            'pv_assemblee': 'PV Assemblée constitutive',
            'liste_membres': 'Liste des membres fondateurs',
            'plan_action': 'Plan d\'action',
            'pieces_identite': 'Pièces d\'identité',
            'lettre_demande': 'Lettre de demande'
        };
        
        documents.forEach(doc => {
            const file = document.getElementById(doc).files[0];
            if (file) {
                html += `<li class="text-green-600 dark:text-green-400">✓ ${documentLabels[doc]} (${file.name})</li>`;
            } else {
                html += `<li class="text-red-600 dark:text-red-400">✗ ${documentLabels[doc]} - Manquant</li>`;
            }
        });
        
        html += '</ul></div>';
        
        summaryContent.innerHTML = html;
    }

    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStep();
            }
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStep();
        }
    });

    // Gestionnaire pour le bouton de soumission
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Vérifier la case de confirmation
        const confirmationCheckbox = document.getElementById('confirmation');
        if (!confirmationCheckbox.checked) {
            alert('Vous devez confirmer que toutes les informations sont exactes avant de soumettre votre demande.');
            confirmationCheckbox.focus();
            return;
        }
        
        // Valider toutes les étapes précédentes
        let allValid = true;
        for (let step = 1; step <= 2; step++) { // Valider seulement les étapes 1 et 2
            if (!validateStep(step)) {
                allValid = false;
                currentStep = step;
                updateStep();
                break;
            }
        }
        
        if (allValid) {
            // Désactiver le bouton pour éviter les doubles soumissions
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Soumission en cours...
            `;
            
            // Soumettre le formulaire
            setTimeout(() => {
                document.getElementById('chamber-form').submit();
            }, 500);
        }
    });

    // Initialize
    updateStep();
});
</script>
@endsection