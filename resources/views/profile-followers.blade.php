<x-profile :sharedData="$sharedData" doctitle="{{ auth()->user()->username }}'s Followers">
  @include('profile-followers-only')
</x-profile>