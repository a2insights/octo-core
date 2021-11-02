<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.6/dist/inputmask.min.js"></script>

<div>
    <x-jet-label for="phone" value="{{ __('Phone Number') }}" />
    <div
        x-data="select({ data: {{ $countries }}, value: {{ $country }} , emptyOptionsMessage: '{{ __('No countries match your search.')}}', name: 'country', placeholder: '{{ __('Select a country') }}' })"
        x-init="init()"
        @click.away="closeListbox()"
        @keydown.escape="closeListbox()"
        class="relative flex"
    >
        <span class="inline-block mt-1 rounded-md shadow-sm">
            <button
                x-ref="button"
                @click.prevent="toggleListboxVisibility()"
                :aria-expanded="open"
                aria-haspopup="listbox"
                style="max-height: 42px;"
                class="items-center flex relative z-0 py-2 pr-4 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
            >
                <div class="flex mr-2">
                    <span
                        x-show="! open"
                        x-text="value ? value.flag + '&nbsp;&nbsp;+' + value.calling_code : placeholder"
                        :class="{ 'text-gray-500': ! value }"
                        class="block truncate ml-3">asdfas
                    </span>
                    <span x-show="! open" class="absolute inset-y-0 mr-1 right-0 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
            </button>
        </span>
        <div
            x-show="open"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
            class="absolute z-5 w-full mt-1 bg-white rounded-md shadow-lg"
        >
            <input
                x-ref="search"
                x-show="open"
                @keydown.enter.stop.prevent="selectOption()"
                @keydown.arrow-up.prevent="focusPreviousOption()"
                @keydown.arrow-down.prevent="focusNextOption()"
                x-model="search"
                type="search"
                class="w-full z-10 h-full form-control focus:outline-none rounded-md"
            />
            <ul
                x-ref="listbox"
                @keydown.enter.stop.prevent="selectOption()"
                @keydown.arrow-up.prevent="focusPreviousOption()"
                @keydown.arrow-down.prevent="focusNextOption()"
                role="listbox"
                :aria-activedescendant="focusedOptionOptionId ? name + 'Option' + focusedOptionOptionId : null"
                tabindex="-1"
                :style="{ 'height': ulSize}"
                class="py-1 overflow-auto text-base leading-6 rounded-md shadow-xs h-20 md:h-full focus:outline-none sm:text-sm sm:leading-5"
            >
                <template x-for="(option, index) in options" :key="index">
                    <li
                        :id="name + 'Option' + focusedOptionOptionId"
                        @click="selectOption()"
                        @mouseenter="focusedOptionOptionId = option.id"
                        @mouseleave="focusedOptionOptionId = null"
                        role="option"
                        :aria-selected="focusedOptionOptionId === option.id"
                        :class="{ 'text-white bg-indigo-600': option.id === focusedOptionOptionId, 'text-gray-900': option.id !== focusedOptionOptionId }"
                        class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9"
                    >
                        <div class="flex items-center">
                            <span x-text="option.flag" class="mr-2"></span>
                            <span x-text="option.name"
                                  :class="{ 'font-semibold': option.id === focusedOptionOptionId, 'font-normal': option.id !== focusedOptionOptionId }"
                                  class="block font-normal truncate">
                            </span>
                            <span
                                x-text="`+${option.calling_code}`"
                                :class="{ 'text-white': option.id !== focusedOptionOptionId, 'text-indigo-600': option.id !== focusedOptionOptionId }"
                                class="mr-2 absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                            >
                            </span>
                            <span
                                x-show="option === value"
                                :class="{ 'text-white': option.id === focusedOptionOptionId, 'text-indigo-600': option.id !== focusedOptionOptionId }"
                                class="absolute inset-y-0 right-0 ml-3 flex items-center pr-2 text-indigo-600"
                            >
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                    </li>
                </template>
                <div
                    x-show="! options.length"
                    x-text="emptyOptionsMessage"
                    class="px-3 py-2 text-gray-900 cursor-default select-none"
                ></div>
            </ul>
        </div>
        <x-jet-input
            type="hidden"
            id="calling_code"
            name="calling_code"
            x-model="value ? value.calling_code : value"
        />
        <x-jet-input
            name="phone"
            id="phone"
            class="mt-1 ml-2 w-full"
            type="text"
            :value="old('phone')"
        />
    </div>

    <script>
        function select(config) {
            return {
                data: config.data,
                emptyOptionsMessage: '{{ __('No results match your search.') }}',
                focusedOptionOptionId: null,
                focusedOptionIndex: null,
                name: 'country',
                open: false,
                options: {},
                placeholder: '{{ __('Select') }}',
                search: '',
                value: config.value,
                ulSize: '10rem',

                closeListbox: function () {
                    this.open = false
                    this.focusedOptionOptionId = null
                    this.search = ''
                    this.ulSize = '10rem'
                },

                focusNextOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = this.options.length - 1

                    if (this.focusedOptionIndex + 1 >= this.options.length) return

                    this.focusedOptionIndex++

                    this.$refs.listbox.children[this.focusedOptionIndex++].scrollIntoView({
                        block: 'center',
                    })
                },

                focusPreviousOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

                    if (this.focusedOptionIndex <= 0) return

                    this.focusedOptionIndex--

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: 'center',
                    })
                },

                init: function () {
                    this.options = this.data

                    @if(old('calling_code'))
                        this.value = this.data.filter(c => c.calling_code == {{ old('calling_code') }})[0]
                        this.formatPhone()
                    @else
                        if (!this.value) {
                            fetch('https://extreme-ip-lookup.com/json')
                                .then( res => res.json())
                                .then(response => {
                                    this.value = this.data.filter(c => c.id.toLowerCase() === response.countryCode.toLowerCase())[0]
                                    this.formatPhone()
                                })
                                .catch(() => {
                                    this.value = this.options[0];
                                    this.formatPhone()
                                })
                        } else {
                            this.formatPhone()
                        }
                    @endif

                    this.$watch('search', ((value) => {
                        if (!this.open || !value) return this.options = this.data

                        this.options = this.data
                            .filter((country) => country.name
                                .normalize('NFD')
                                .replace(/[\u0300-\u036f]/g, '')
                                .toLowerCase()
                                .includes(
                                    value .normalize('NFD')
                                    .replace(/[\u0300-\u036f]/g, '')
                                    .toLowerCase())
                            )

                        if (this.options.length < 5) {
                            this.ulSize = 'auto'
                        } else {
                            this.ulSize = '10rem'
                        }
                    }))
                },

                formatPhone() {
                    Inputmask(this.value.phone_format).mask(document.getElementById('phone'));
                },

                selectOption: function () {
                    if (!this.open) return this.toggleListboxVisibility()

                    this.value = this.data.filter(c => c.id === this.focusedOptionOptionId)[0]

                    this.formatPhone()

                    this.closeListbox()
                },

                toggleListboxVisibility: function () {
                    if (this.open) return this.closeListbox()

                    this.focusedOptionIndex = this.options.indexOf(this.value)

                    if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                    this.open = true

                    this.$nextTick(() => {
                        this.$refs.search.focus()
                        this.$refs.listbox.children[this.focusedOptionIndex+2].scrollIntoView({
                            block: 'center'
                        })
                    })
                },
            }
        }
    </script>
</div>

