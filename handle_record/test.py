import re

def handle_name(line):
    r = line.split()
    time = r[0] +  ' ' + r[1]
    regex = '[<|\(][\S]+[>|\)]'
    number = re.search(regex, line).group()
    number = number[1:-1]
    return number, time


def handle_message(line):
    regex = '#.*?#'
    temps = re.findall(regex, line)
    results = []
    for temp in temps:
        if temp not in results:
            results.append(temp)
    real_result = ' '.join(results)
    return real_result


numbers = []
times = []
labels = []
contents = []


with open('record.txt', 'r', encoding='utf-8') as file:
    regex = '\d{4}-\d{2}-\d{2}\s\d{1,2}:\d{2}:\d{2}'
    lines = file.readlines()
    for i in range(len(lines)):
        content =  ''
        imf = re.search(regex, lines[i])
        if imf:
            imf = lines[i]
            i+=1
            while i < len(lines) and not re.search(regex, lines[i]):
                content += lines[i].strip()
                i += 1
            i-=1
            number, time = handle_name(imf)
            label = handle_message(content)

            numbers.append(number)
            times.append(time)
            labels.append(label)
            contents.append(content)
            print(number)
            print(time.strip())
            print(label)
            print(content)
            print('---------------------------------------------')


with open('results.csv', 'w', encoding='utf-8') as results:
    for i in range(len(numbers)):
        if numbers[i] == '1000000' or numbers[i] == '10000' or numbers[i] == '80000000':
            continue
        else:
            result = numbers[i].strip() + ', ' + times[i].strip() + ', ' + labels[i].strip() + ', ' + contents[i].strip() + '\n'
            results.write(result)
