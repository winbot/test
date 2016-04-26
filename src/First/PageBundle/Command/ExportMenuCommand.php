<?php

namespace First\PageBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ExportMenuCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('export:menu')
            ->setDescription('Export menu data to file.xls');
/*            ->addArgument('path', InputArgument::REQUIRED, 'Enter path to file')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description');*/
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter path and name a file export: ', '/home/vagrant');

        //Путь к файлу экспорта
        $path = $helper->ask($input, $output, $question);
        
        //Получаем контейнер
        $gk = $this->getContainer();
        $em = $this->getContainer()->get('doctrine')->getManager();
        //Получаем список групп меню
        //************************************
        $res_tabl = $em->getRepository("FirstPageBundle:main_menu")->findAll();
        if (!$res_tabl)
        {
            throw $this->createNotFoundException('Not found table Repository');
        }
        $col_tabl = count($res_tabl);//количество групп меню
        //************************************

        // Экспорт данных в файл xls
        $phpExcelObject = $gk->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("Admin")
            ->setLastModifiedBy("Admin")
            ->setTitle("Title")
            ->setSubject("Office 2005 XLSX Subject Document")
            ->setDescription("Export menu")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Export menu file");

        for($i = 0; $i < $col_tabl; $i++){
            //Получаем имя текущей таблицы
            $name_tab = $res_tabl[$i]->getNameTab();
            //Формируем массив с детальным описанием текущей группы меню
            //************************************
            $repo = 'FirstPageBundle:';
            $repo .= $name_tab;
            $cur_tabl = $em->getRepository($repo)->findAll();
            if (!$res_tabl)
            {
                throw $this->createNotFoundException('Not found table Repository');
            }
            $col_item = count($cur_tabl);//количество позиций в группе меню
            //************************************
            $phpExcelObject->createSheet($i);
            $phpExcelObject->setActiveSheetIndex($i)
                ->setCellValue('A1', "id")
                ->setCellValue('B1', "Название")
                ->setCellValue('C1', "Количество гр.")
                ->setCellValue('D1', "Цена грн.")
                ->setCellValue('E1', "Описание");

            //Сохраняем текущую таблицу группы меню на сраницу $K файла
            for($k = 0; $k < $col_item; $k++){
                //$phpExcelObject->createSheet(1);

                    $cell = $k+2;
                    $phpExcelObject->setActiveSheetIndex($i)
                        ->setCellValue('A'. $cell, $cur_tabl[$k]->getId())
                        ->setCellValue('B'. $cell, $cur_tabl[$k]->getName())
                        ->setCellValue('C'. $cell, $cur_tabl[$k]->getPortion())
                        ->setCellValue('D'. $cell, $cur_tabl[$k]->getCost())
                        ->setCellValue('E'. $cell, $cur_tabl[$k]->getComposition());
            }
            $phpExcelObject->getActiveSheet()->setTitle($name_tab);
        }
        // Устанавливаем индекс активной страницы
       $phpExcelObject->setActiveSheetIndex(0);

        // Создаём редактор
        $writer = $gk->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
       
        // Сохраняем файл
        $writer->save($path);

        $output->writeln($path);
    }

}
