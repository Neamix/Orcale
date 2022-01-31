
export default { 
    data() {
        return {
            errors: {
                'validType': 'this is not a valid type',
            }
        }
    },
    chunk(arr,chunk)
    {
        let index = 0;
        let arrBack = [];

        if(typeof arr == 'object')
        {
            let arrRefind;
            for (const key in arr) {
                arrRefind.push(arr[key]);
            }
        }
        
        if(typeof chunk == 'number')
        {

            if(typeof arr == 'array')
            {
                let chunkFun = () => {
                    let spliced = arr.splice(index,chunk);
                    console.log(spliced);
                    arrBack.push(spliced);
                    console.log(arrBack);
                    if(arr.length !== 0)
                    {
                        chunkFun();
                    } else {
                        console.log(arrBack);
                        return arrBack;
                    }
        
                }  
                chunkFun() 
            } 

        } else throw 'Chunked value must be a number'
    }
};