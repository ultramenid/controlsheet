<div class="mt-6 z-20 relative">
    <h1 class="text-3xl font-semibold text-gray-700">Alerts</h1>
    <div class="flex mt-4">
        <input class="sm:w-52 w-full py-2 border-gray-500 border px-2 focus:outline-none" wire:model.live='searchId' placeholder="alert ID">
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
                    <th wire:click='sortingField("name")' class="bg-gray-50 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-2/12 w-4/12 hidden sm:table-cell ">
                       <div class="flex space-x-1">
                           <a>Analyst</a>
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
                    <td class="px-6 py-4 break-words text-sm  text-gray-700 ">
                        <a>{{$item->alertId}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-sm  text-gray-700 hidden sm:table-cell">
                        <a>{{ $item->name }}</a>
                    </td>

                    <td class="px-6 py-4 break-words text-sm  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->region}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-sm  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->province}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-sm  text-gray-700">
                        @if (!$item->auditorStatus)
                            <a  wire:click="showAudit({{ $item->alertId }})" @click.away="open = false" class="cursor-pointer rounded-xs  bg-gray-300 px-2 py-1">Pending</a>
                        @elseif ($item->auditorStatus == 'approved')
                            <a  class="rounded-xs  bg-green-700 px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @else
                            <a  class="rounded-xs   bg-red-700 px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
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
                    <td colspan="5" class="whitespace-nowrap text-sm text-gray-700 px-6 py-3">
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
</div>
