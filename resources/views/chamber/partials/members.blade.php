<div data-chamber-tab="members" class="hidden p-4 sm:p-6">
    <div class="rounded-xl border border-neutral-200 bg-white shadow-sm overflow-hidden">
        <div class="border-b border-neutral-200 px-4 py-3 flex items-center justify-between">
            <h3 class="text-sm font-semibold tracking-tight">Active Members</h3>
            <div class="relative">
                <input type="text" placeholder="Search members" class="w-48 rounded-md border border-neutral-200 bg-white pl-3 pr-9 py-1.5 text-xs focus:border-[#E71D36] focus:ring-2 focus:ring-[#E71D36]/20">
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-neutral-400">
                    <i data-lucide="search" class="h-3.5 w-3.5"></i>
                </span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-neutral-50 text-neutral-600">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">Company</th>
                        <th class="px-4 py-2 text-left font-medium">Contact</th>
                        <th class="px-4 py-2 text-left font-medium">Email</th>
                        <th class="px-4 py-2 text-left font-medium">Phone</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @foreach($members as $member)
                    <tr class="hover:bg-neutral-50">
                        <td class="px-4 py-2">{{ $member->company }}</td>
                        <td class="px-4 py-2">{{ $member->contact_name }}</td>
                        <td class="px-4 py-2 text-[#E71D36]">{{ $member->email }}</td>
                        <td class="px-4 py-2">{{ $member->phone }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
