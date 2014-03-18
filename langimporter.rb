require 'open-uri'
require 'csv'

url = 'https://docs.google.com/spreadsheet/pub?key=0AoVR4wFeDQrYdDU4WlN2TmhSeXhCY1M0ZVpIcVVyYnc&single=true&gid=0&output=csv'

def read(url)
 CSV.new(open(url), :headers => :first_row).each do |line|
   puts line[0]

 end
end

read(url)
