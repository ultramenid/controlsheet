<div class="py-6 px-4 border border-gray-100 z-20 relative  bg-white">
    <div class="text-sm mb-6">
        <a>Alert status by region</a>
    </div>

    <div class="overflow-y-auto w-full">
        <table class="w-full border-collapse border-b border-gray-300">
          <thead class="text-xs font-semibold">
            <tr class="bg-gray-50 text-left">
              <th class="border-b border-gray-300 px-4 py-2">Status</th>
              <th class="border-b border-gray-300 px-4 py-2">Bali & Nusa Tenggara</th>
              <th class="border-b border-gray-300 px-4 py-2">Java</th>
              <th class="border-b border-gray-300 px-4 py-2">Kalimantan</th>
              <th class="border-b border-gray-300 px-4 py-2">Maluku</th>
              <th class="border-b border-gray-300 px-4 py-2">Papua</th>
              <th class="border-b border-gray-300 px-4 py-2">Sulawesi</th>
              <th class="border-b border-gray-300 px-4 py-2">Sumatra</th>
              <th class="border-b border-gray-300 px-4 py-2">TOTAL</th>
            </tr>
          </thead>
          <tbody class="text-xs">
            @foreach ($alerts as $item )
                <tr class="border-t">
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['auditorStatus']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Balinusatenggara']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Java']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Kalimantan']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Maluku']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Papua']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Sulawesi']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['Sumatra']}}</td>
                    <td class="@if($item['auditorStatus'] === 'Grand Total') bg-gray-100 @endif border-b border-gray-300 px-4 py-2">{{$item['TOTAL']}}</td>
                </tr>
            @endforeach


          </tbody>
        </table>
      </div>



</div>
