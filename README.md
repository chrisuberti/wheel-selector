# Wheel Selector 

<hr>

Used the follow website as some reference, mainly obtained CdA for varoius positions here

https://www.cyclingpowerlab.com/CyclingAerodynamics.aspx

 Linear correlation of BSA to cyclist frontal area from paper on hour records this is for drops, need to correlate back out to which riding position you're in
 https://www.ncbi.nlm.nih.gov/pubmed/21936289

BSA corrects the CdA value for rider height

The result of this gives an approximate CdA for each riding position
    - This assumes that rider does NOT have special Aero gear (i.e. relatively normal kit)
    - Also assumes traditional Non-aero wheelsets (Going to use Boyd Altamont Wheelset as baseline)
        - This is done since the wheelset closely approximates an older (90's aero w/s)
    
First cut of program will not take into account crosswinds (i.e.)
    - wind_cor_wheel_cda function will just return a value of 1.0 * drag0
    - Future will involve some uberti correlation of crosswind direction
        - Will reference previous blog post on crosswinds in order to determine
    