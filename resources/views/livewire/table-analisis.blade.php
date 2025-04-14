<div class="mt-2 z-20 relative">
    <div x-data="{ open: @entangle('isReason') }">
        @include('partials.auditorReason')
    </div>
    <div class="">
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
                    <th wire:click='sortingField("alertStatus")' class="bg-gray-50 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-3/12 w-4/12 hidden sm:table-cell ">
                       <div class="flex space-x-1">
                           <a>Alert Status</a>
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </th>
                    <th  class="bg-gray-50 px-6 py-4    text-left   text-gray-700 uppercase tracking-wider  sm:w-2/12 w-4/12 hidden sm:table-cell">
                        <div class="flex space-x-1">
                            <a>Region/Island</a>
                         </div>
                     </th>
                     <th  class="bg-gray-50 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider  sm:w-3/12 w-11/12 hidden sm:table-cell">
                        <div class=" space-x-1 " >
                            <a >Province</a>

                         </div>
                     </th>
                     <th wire:click='sortingField("auditorStatus")' class="bg-gray-50 px-6 py-4   text-left   text-gray-700 uppercase tracking-wider cursor-pointer sm:w-4/12 w-4/12">
                        <div class="flex space-x-1">
                            <a>Auditor Status</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 my-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                             </svg>
                         </div>
                     </th>






                    <th class=" text-right bg-gray-50   text-gray-700 uppercase tracking-wider w-1/12 hidden sm:table-cell">

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
                        <a>{{ $item->alertStatus }}</a>
                    </td>

                    <td class="px-6 py-4 break-words text-sm  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->region}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-sm  text-gray-700 hidden sm:table-cell">
                        <a >{{$item->province}}</a>
                    </td>
                    <td class="px-6 py-4 break-words text-sm  text-gray-700">
                        @if (!$item->auditorStatus)
                            <a class="rounded-xs  bg-gray-300 px-2 py-1">Pending</a>
                        @elseif ($item->auditorStatus == 'approved')
                            <a  class="rounded-xs  bg-green-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @elseif ($item->auditorStatus == 'duplicate' or $item->auditorStatus == 'rejected')
                            <a  class="rounded-xs  bg-merah-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @else
                            <a wire:click="showReason({{ $item->id }})" @click.away="open = false" class="rounded-xs cursor-pointer  bg-yellow-alerta px-2 py-1 text-gray-100">{{$item->auditorStatus}}</a>
                        @endif
                    </td>

                    <td>

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
