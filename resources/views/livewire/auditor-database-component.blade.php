<div class="mt-6 z-20 relative">
    <h1 class="text-3xl font-semibold text-gray-700">Alerts</h1>
    <div class="flex gap-4 sm:flex-row flex-col mt-4">
        <input class="sm:w-52 w-full py-2 border-gray-500 border px-2 focus:outline-none" wire:model.live='searchId' placeholder="alert ID">
        <div class="flex flex-col">
            <a class="text-xs ">Status</a>
            <div class="sm:w-36 w-full relative flex  flex-col  text-neutral-600 dark:text-neutral-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-2 size-5">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:ignore wire:model.live='selectStatus'class=" w-full appearance-none text-black  border border-neutral-300 bg-gray-100 px-4 py-2 text-xs focus:outline-none">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col">
            <a class="text-xs ">Tahun</a>
            <div class="sm:w-36 w-full relative flex  flex-col  text-neutral-600 dark:text-neutral-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-2 size-5">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:ignore id='date-dropdown' wire:model.live="yearAlert" class=" w-full appearance-none text-black  border border-neutral-300 bg-gray-100 px-4 py-2 text-xs focus:outline-none">
                    <option value="all">all</option>
                </select>
            </div>

        </div>


    </div>
    <div x-data="{ open: @entangle('isAudit') }">
        @include('partials.auditing')
    </div>
    <div x-data="{ open: @entangle('deleter') }">
        @include('partials.deleterAlert')
    </div>
    <div class="mt-4">
        <table class="w-full divide-y divide-gray-200  rounded-sm  border border-gray-100">
            <thead class="text-xs">
                <tr >
                    <th wire:click='sortingField("alertId")'  class="bg-gray-50 px-6 py-4  cursor-pointer   text-left  text-gray-700 uppercase tracking-wider  sm:w-2/12 w-4/12">
                        <div class=" space-x-1 flex" >
                            <a class="">Alert ID</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                         </div>
                     </th>
                    <th wire:click='sortingField("alerts.created_at")' class="bg-gray-50 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-2/12 w-4/12 hidden sm:table-cell ">
                       <div class="flex space-x-1">
                           <a>Input date</a>
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                    <th  class="bg-gray-50 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider  sm:w-3/12 w-4/12 hidden sm:table-cell">
                        <div class="flex space-x-1">
                            <a>Region/Island</a>
                         </div>
                     </th>
                     <th  class="bg-gray-50 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider  sm:w-2/12 w-11/12 hidden sm:table-cell">
                        <div class=" space-x-1 " >
                            <a >Province</a>

                         </div>
                     </th>
                     <th wire:click='sortingField("auditorStatus")' class="bg-gray-50 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-4/12 w-4/12">
                        <div class="flex space-x-1">
                            <a>Audit</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                             </svg>
                         </div>
                     </th>
                    <th class=" text-right bg-gray-50   text-gray-700 uppercase tracking-wider sm:w-1/12 table-cell">

                    </th>
                </tr>
            </thead>
            <tbody class="bg-white  divide-y divide-gray-200 ">
                @forelse ($databases as $item)
                <tr>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 ">
                        <a>{{$item->alertId}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 hidden sm:table-cell">
                        @php
                            $date = \Carbon\Carbon::parse($item->created_at)->locale(App::getLocale());
                            $date->settings(['formatFunction' => 'translatedFormat']);
                        @endphp</h1>
                        <a>{{ $date->format('d-m-Y')  }}</a>
                    </td>

                    <td class="px-6 py-4 break-words text-xs  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->region}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->province}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-xs  text-gray-700">
                        @if (!$item->auditorStatus)
                            <a  wire:click="showAudit({{ $item->alertId }})" @click.away="open = false" class="cursor-pointer rounded-xs  bg-gray-300 px-2 py-1">Pending</a>
                        @elseif ($item->auditorStatus == 'approved')
                            <a  class="rounded-xs  bg-green-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @elseif ($item->auditorStatus == 'duplicate' or $item->auditorStatus == 'rejected')
                            <a  class="rounded-xs  bg-merah-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @else
                            <a  class="rounded-xs   bg-yellow-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @endif
                    </td>

                    <td class="text-center pr-12 w-2/12">
                        <svg  wire:click="deleteAlert({{ $item->alertId }})" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-red-500 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="whitespace-nowrap text-xs text-gray-700 px-6 py-3">
                        No data found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($databases)
    {{ $databases->links('livewire.pagination') }}
    @endif

    <script>
        let dateDropdown = document.getElementById('date-dropdown');

        let currentYear = new Date().getFullYear();
        let earliestYear = 2020;
        while (currentYear >= earliestYear) {
            let dateOption = document.createElement('option');
            dateOption.text = currentYear;
            dateOption.value = currentYear;
            dateDropdown.add(dateOption);
            currentYear -= 1;
        }

    </script>
</div>
